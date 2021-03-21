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
        $types = (new \ReflectionClass(MyField::class))
            ->getMethods();
        $types = collect($types)
            ->filter(function (\ReflectionMethod $method) {
                $params = collect($method->getParameters())
                    ->pluck('name')
                    ->toArray();

                return !Str::startsWith($method->getShortName(), ['with', 'default'])
                    and in_array('name', $params)
                    and in_array('title', $params);
            })
            ->pluck('name')
            ->flip()
            ->map(function ($val, $key) {
                return $key;
            })
            ->toArray();

        return [
            MyField::input('key')
                ->required(),
            MyField::input('name')
                ->required(),
            MyField::select('type', null, $types)
                ->required(),
            MyField::switcher('editable')
                ->required(),
            MyField::textArea('value')
                ->required()
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
            MyTD::text('type'),
            MyTD::boolean('editable')
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

    public function onSave(ResourceRequest $request, Model $model)
    {
        $this->saveWithAttachment($request, $model);
    }
}
