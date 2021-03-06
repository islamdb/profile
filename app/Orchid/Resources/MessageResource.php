<?php

namespace App\Orchid\Resources;

use App\Models\Message;
use App\Orchid\Actions\DeleteAction;
use App\Support\MyField;
use App\Support\MyTD;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\TD;

class MessageResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Message::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            MyField::input('name')
                ->disabled(),
            MyField::input('subject')
                ->disabled(),
            MyField::input('email')
                ->disabled(),
            MyField::input('phone')
                ->disabled(),
            MyField::textArea('body', 'Message')
            ->disabled()
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
            MyTD::name(),
            MyTD::text('subject'),
            MyTD::createdAt(),
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
        return 'envelope';
    }

    public function actions(): array
    {
        return [
            DeleteAction::class
        ];
    }
}
