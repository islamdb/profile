<?php


namespace App\Support;


use Illuminate\Support\Str;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use ReflectionClass;

class MyTD
{
    public static function boolean($name, $title = null, $labels = [true => 'Yes', false => 'No'])
    {
        $title = is_null($title)
            ? Str::title(str_replace('_', ' ', $name))
            : $title;

        return TD::make($name, $title)
            ->sort()
            ->render(function ($model) use ($labels, $name) {
                return $labels[$model->{$name}];
            });
    }

    public static function dateTime($name, $title = null, $locale = 'id')
    {
        return self::text($name, $title)
            ->render(function ($model) use ($locale, $name){
                return readable_datetime($model->{$name}, $locale);
            })
            ->filter(TD::FILTER_DATE);
    }

    public static function money($name, $title = null)
    {
        return self::text($name, $title)
            ->render(function ($model) use ($name) {
                return number_format(
                    $model->{$name},
                    2,
                    ',',
                    '.'
                );
            })
            ->filter(TD::FILTER_NUMERIC);
    }

    public static function text($name, $title = null)
    {
        $title = is_null($title)
            ? Str::title(str_replace('_', ' ', $name))
            : $title;

        return TD::make($name, $title)
            ->sort()
            ->filter(TD::FILTER_TEXT);
    }

    public static function textWithShortcut($name, $title = null, $deep = 2)
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

        return self::text($name, $title)
            ->render(function ($model) use ($resource, $name) {
                return Link::make($model->{$name})
                    ->route('platform.resource.edit', [
                        'resource' => $resource,
                        'id' => $model->id ?? $model->key
                    ]);
            });
    }

    public static function name()
    {
        return self::textWithShortcut('name', null, 3);
    }

    public static function title()
    {
        return self::textWithShortcut('title', null, 3);
    }

    public static function createdAt()
    {
        return self::dateTime('created_at');
    }
}
