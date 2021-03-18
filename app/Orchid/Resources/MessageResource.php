<?php

namespace App\Orchid\Resources;

use App\Models\Message;
use App\Orchid\Actions\DeleteAction;
use App\Support\OrchidTD;
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
            Input::make('name')
                ->title('Name')
                ->horizontal()
                ->disabled(),
            Input::make('subject')
                ->title('Subject')
                ->horizontal()
                ->disabled(),
            Input::make('email')
                ->title('Email')
                ->horizontal()
                ->disabled(),
            Input::make('phone')
                ->title('Phone')
                ->horizontal()
                ->disabled(),
            TextArea::make('body')
                ->title('Message')
                ->horizontal()
                ->disabled()
                ->rows(10)
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
            OrchidTD::name(),
            OrchidTD::text('subject'),
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
}
