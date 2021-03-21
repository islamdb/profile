<?php

namespace App\Orchid\Resources;

use App\Models\Slider;
use App\Orchid\Actions\DeleteAction;
use App\Support\MyField;
use App\Support\MyTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\TD;

class SliderResource extends Resource
{
    use ResourceOnSave;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Slider::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            MyField::input('title')
                ->required(),
            MyField::uploadPicture('attachment', 'Image')
                ->maxFiles(1),
            MyField::textArea('description'),
            MyField::textArea('url'),
            MyField::switcher('url_new_tab', 'Open URL In New Tab')
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            MyTD::title(),
            MyTD::text('url'),
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
        return 'layers';
    }

    public function onSave(ResourceRequest $request, Model $model)
    {
        $this->saveWithAttachment($request, $model);
    }
}
