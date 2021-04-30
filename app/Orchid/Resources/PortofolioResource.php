<?php

namespace App\Orchid\Resources;

use App\Models\Portofolio;
use App\Models\PortofolioCategory;
use App\Orchid\Actions\DeleteAction;
use App\Support\MyField;
use App\Support\MyTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\TD;

class PortofolioResource extends Resource
{
    use ResourceOnSave;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Portofolio::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function fields(): array
    {
        return MyField::withSlug('name', MyField::withMeta([
            MyField::relation('categories')
                ->fromModel(PortofolioCategory::class, 'name')
                ->multiple(),
            MyField::uploadMedia(),
            MyField::quill('body')
        ]));
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            MyTD::name(),
            TD::make('categories')
                ->render(function ($model) {
                    return $model->categories
                        ->pluck('name')
                        ->map(function ($name) {
                            return badge($name);
                        })
                        ->join('&nbsp;');
                }),
            MyTD::createdAt()
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            new DefaultSorted('created_at', 'desc')
        ];
    }

    public function actions(): array
    {
        return [
            DeleteAction::class
        ];
    }

    public function with(): array
    {
        return [
            'categories' => function ($q) {
                $q->select(['id', 'name']);
            }
        ];
    }

    public static function icon(): string
    {
        return 'docs';
    }

    public function onSave(ResourceRequest $request, Model $model)
    {
        $this->sluggable($request, 'name');

        $categories = $request->categories;
        $request->request
            ->remove('categories');

        DB::beginTransaction();

        $this->saveWithAttachment($request, $model);

        $model->categories()
            ->detach();
        $model->categories()
            ->attach($categories);

        DB::commit();
    }

    public static function displayInNavigation(): bool
    {
        return false;
    }
}
