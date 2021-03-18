<?php

namespace App\Orchid\Resources;

use App\Models\Page;
use App\Orchid\Actions\DeleteAction;
use App\Support\OrchidField;
use App\Support\OrchidTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\TD;

class PageResource extends Resource
{
    use ResourceOnSave;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Page::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return OrchidField::withSlug(
            'title',
            OrchidField::withMeta([
                Picture::make('image')
                    ->title('Banner')
                    ->horizontal(),
                Select::make('placement')
                    ->title('Navigation Placement')
                    ->options([
                        'main navbar' => 'Main Navbar',
                        'navbar dropdown' => 'Navbar Dropdown',
                    ])
                    ->horizontal()
                    ->required(),
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
            OrchidTD::title(),
            OrchidTD::text('placement'),
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

    public function onSave(ResourceRequest $request, Model $model)
    {
        $this->sluggable($request);

        parent::onSave($request, $model);
    }
}
