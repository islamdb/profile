<?php

namespace App\Orchid\Resources;

use App\Models\PortofolioCategory;
use App\Orchid\Actions\DeleteAction;
use App\Support\OrchidField;
use App\Support\OrchidTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\TD;

class PortofolioCategoryResource extends Resource
{
    use ResourceOnSave;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PortofolioCategory::class;

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
                Upload::make('attachment')
                    ->title('Icon/Image')
                    ->acceptedFiles('image/*')
                    ->maxFiles(1)
                    ->horizontal(),
                TextArea::make('description')
                    ->title('Description')
                    ->rows(5)
                    ->horizontal(),
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
            OrchidTD::createdAt()
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
            'portofolios'
        ];
    }

    public function onSave(ResourceRequest $request, Model $model)
    {
        $this->sluggable($request, 'name');

        $this->saveWithAttachment($request, $model);
    }
}
