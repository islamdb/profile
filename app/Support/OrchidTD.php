<?php


namespace App\Support;


use Illuminate\Support\Str;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use ReflectionClass;

class OrchidTD
{
    public static function text($name)
    {
        return TD::make($name)
            ->sort()
            ->filter(TD::FILTER_TEXT);
    }

    public static function textWithShortcut($name, $deep = 2)
    {
        $resource = Str::plural(
            Str::snake(
                (new ReflectionClass(
                    debug_backtrace(
                        DEBUG_BACKTRACE_PROVIDE_OBJECT,
                        $deep
                    )[$deep - 1]['object']
                ))->getShortName(),
                '-'
            )
        );

        return self::text($name)
            ->render(function ($model) use ($resource, $name) {
                return Link::make($model->{$name})
                    ->route('platform.resource.edit', [
                        'resource' => $resource,
                        'id' => $model->id
                    ]);
            });
    }

    public static function name()
    {
        return self::textWithShortcut('name', 3);
    }

    public static function title()
    {
        return self::textWithShortcut('title', 3);
    }

    public static function createdAt()
    {
        return TD::make('created_at', 'Date of creation')
            ->render(function ($model) {
                return $model->created_at
                    ->toDateTimeString();
            })
            ->sort()
            ->filter(TD::FILTER_DATE);
    }
}
