<?php

namespace App\Orchid\Resources;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Support\MyField;
use App\Support\MyTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\TD;

class ProductResource extends Resource
{
    use ResourceOnSave;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Product::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return MyField::withSlug('name', MyField::withMeta([
            MyField::relation('categories')
                ->fromModel(ProductCategory::class, 'name')
                ->multiple(),
            MyField::uploadMedia(),
            MyField::input('price')
                ->step(0.001)
                ->required(),
            MyField::input('discount')
                ->step(0.001)
                ->required(),
            MyField::quill('body'),
            MyField::switcher('is_active')
                ->value(true)
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
            MyTD::boolean('is_active'),
            TD::make('categories')
                ->render(function ($model) {
                    return $model->categories
                        ->pluck('name')
                        ->map(function ($name) {
                            return badge($name);
                        })
                        ->join('&nbsp;');
                }),
            MyTD::money('price'),
            MyTD::money('discount'),
            MyTD::text('presentage')
                ->render(function ($model) {
                    return $model->discount_presentage.'%';
                })
                ->sort(false),
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

    public static function icon(): string
    {
        return 'bag';
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
