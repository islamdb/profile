<?php

namespace App\Orchid\Resources;

use App\Models\Company;
use App\Orchid\Actions\DeleteAction;
use App\Support\MyField;
use App\Support\MyTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\TD;

class CompanyResource extends Resource
{
    use ResourceOnSave;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Company::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return MyField::withSlug('name', MyField::withMeta([
            MyField::textArea('address'),
            MyField::map(),
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
            MyTD::text('address'),
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

    public static function icon(): string
    {
        return 'building';
    }

    public function onSave(ResourceRequest $request, Model $model)
    {
        $this->sluggable($request, 'name');

        $this->saveWithAttachment($request, $model);
    }
}
