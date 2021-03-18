<?php

namespace App\Orchid\Resources;

use App\Models\Gallery;
use App\Orchid\Actions\DeleteAction;
use App\Support\OrchidField;
use App\Support\OrchidTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\TD;

class GalleryResource extends Resource
{
    use ResourceOnSave;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Gallery::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return OrchidField::withSlug(
            'name',
            OrchidField::withMeta([
                OrchidField::attachmentImageAndVideo(),
                OrchidField::body()
            ])
        );
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            OrchidTD::name(),
            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at
                        ->toDateTimeString();
                }),
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

    public function onSave(ResourceRequest $request, Model $model)
    {
        $this->sluggable($request, 'name');

        $this->saveWithAttachment($request, $model);
    }
}
