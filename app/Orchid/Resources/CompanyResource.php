<?php

namespace App\Orchid\Resources;

use App\Models\Company;
use App\Orchid\Actions\DeleteAction;
use App\Support\OrchidField;
use App\Support\OrchidTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
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
        return OrchidField::withSlug(
            'name',
            OrchidField::withMeta([
                TextArea::make('address')
                    ->title('Address')
                    ->horizontal(),
                Input::make('lat')
                    ->title('Latitude')
                    ->type('text')
                    ->horizontal(),
                Input::make('lon')
                    ->title('Longitude')
                    ->type('text')
                    ->horizontal(),
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
            OrchidTD::text('address'),
            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at
                        ->toDateTimeString();
                })
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
