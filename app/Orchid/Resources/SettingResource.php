<?php

namespace App\Orchid\Resources;

use App\Models\Setting;
use App\Orchid\Actions\DeleteAction;
use App\Support\MyField;
use App\Support\MyTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\TD;

class SettingResource extends Resource
{
    use ResourceOnSave;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Setting::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            MyField::input('key')
                ->required(),
            MyField::input('name')
                ->required(),
            MyField::switcher('editable')
                ->value(true)
                ->required(),
            MyField::switcher('is_attachment')
                ->required(),
            MyField::upload(),
            MyField::textArea('value')
                ->rows(5),
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
            MyTD::textWithShortcut('key'),
            MyTD::name(),
            MyTD::boolean('editable'),
            MyTD::boolean('is_attachment')
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
            new DefaultSorted('key')
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
        return 'settings';
    }

    public static function sort(): string
    {
        return 2001;
    }

    public function onSave(ResourceRequest $request, Model $model)
    {
        $this->saveWithAttachment($request, $model);
    }
}
