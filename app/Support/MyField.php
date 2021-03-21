<?php


namespace App\Support;


use Illuminate\Support\Str;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Radio;
use Orchid\Screen\Fields\RadioButtons;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\TimeZone;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\UTM;

class MyField
{
    // Input types
    public const INPUT_EMAIL = 'email';
    public const INPUT_FILE = 'file';
    public const INPUT_HIDDEN = 'hidden';
    public const INPUT_MONTH = 'month';
    public const INPUT_NUMBER = 'number';
    public const INPUT_PASSWORD = 'password';
    public const INPUT_RADIO = 'radio';
    public const INPUT_RANGE = 'range';
    public const INPUT_SEARCH = 'search';
    public const INPUT_TEL = 'tel';
    public const INPUT_TEXT = 'text';
    public const INPUT_TIME = 'time';
    public const INPUT_URL = 'url';
    public const INPUT_WEEK = 'week';

    public static function withMeta(array $fields = [])
    {
        return array_merge($fields, [
            SEO::titleField(),
            SEO::keywordsField(),
            SEO::descriptionField()
        ]);
    }

    public static function withSlug(string $referencedName, array $fields)
    {
        return array_merge([
            self::input($referencedName)
                ->maxlength(191)
                ->required(),
            self::input('slug')
                ->maxlength(191)
                ->help('Boleh dikosongi'),
        ], $fields);
    }

    public static function defaultTitle($name, &$title)
    {
        $title = is_null($title)
            ? Str::title(str_replace('_', ' ', $name))
            : $title;
    }

    public static function checkBox($name = 'check_box', $title = null)
    {
        self::defaultTitle($name, $title);

        return CheckBox::make($name)
            ->sendTrueOrFalse()
            ->title($title)
            ->horizontal();
    }

    public static function code($name = 'code', $title = null)
    {
        self::defaultTitle($name, $title);

        return Code::make($name)
            ->lineNumbers()
            ->title($title)
            ->horizontal();
    }

    public static function cropper($name = 'cropper', $title = null)
    {
        self::defaultTitle($name, $title);

        return Cropper::make($name)
            ->title($title)
            ->horizontal();
    }

    public static function dateRange($name = 'date_range', $title = null)
    {
        self::defaultTitle($name, $title);

        return DateRange::make($name)
            ->title($title)
            ->horizontal();
    }

    public static function dateTimer($name = 'date_timer', $title = null)
    {
        self::defaultTitle($name, $title);

        return DateTimer::make($name)
            ->format24hr()
            ->enableTime()
            ->title($title)
            ->horizontal();
    }

    public static function input($name = 'input', $title = null, $type = self::INPUT_TEXT)
    {
        self::defaultTitle($name, $title);

        return Input::make($name)
            ->type($type)
            ->title($title)
            ->horizontal();
    }

    public static function map($name = 'map', $title = null)
    {
        self::defaultTitle($name, $title);

        return Map::make($name)
            ->title($title)
            ->horizontal();
    }

    public static function matrix($name = 'matrix', $title = null, $columns = [])
    {
        self::defaultTitle($name, $title);

        return Matrix::make($name)
            ->columns($columns)
            ->title($title)
            ->horizontal();
    }

    public static function password($name = 'password', $title = null)
    {
        self::defaultTitle($name, $title);

        return Password::make($name)
            ->title($title)
            ->horizontal();
    }

    public static function picture($name = 'picture', $title = null)
    {
        self::defaultTitle($name, $title);

        return Picture::make($name)
            ->title($title)
            ->horizontal();
    }

    public static function quill($name = 'quill', $title = null)
    {
        self::defaultTitle($name, $title);

        return Quill::make($name)
            ->title($title)
            ->horizontal();
    }

    public static function radio($name = 'radio', $title = null, $withTitle = false)
    {
        self::defaultTitle($name, $title);

        $radio = Radio::make($name)
            ->horizontal();

        return $withTitle
            ? $radio->title($title)
            : $radio;
    }

    public static function radioButtons($name = 'radio_buttons', $title = null, array $options = [])
    {
        self::defaultTitle($name, $title);

        return RadioButtons::make($name)
            ->options($options)
            ->title($title)
            ->horizontal();
    }

    public static function relation($name = 'relation', $title = null)
    {
        self::defaultTitle($name, $title);

        return Relation::make($name)
            ->title($title)
            ->horizontal();
    }

    public static function select($name = 'select', $title = null, array $options = [])
    {
        self::defaultTitle($name, $title);

        return Select::make($name)
            ->options($options)
            ->title($title)
            ->horizontal();
    }

    public static function simpleMDE($name = 'simple_mde', $title = null)
    {
        self::defaultTitle($name, $title);

        return SimpleMDE::make($name)
            ->title($title)
            ->horizontal();
    }

    public static function switcher($name = 'switcher', $title = null)
    {
        self::defaultTitle($name, $title);

        return Switcher::make($name)
            ->sendTrueOrFalse()
            ->title($title)
            ->horizontal();
    }

    public static function textArea($name = 'text_area', $title = null)
    {
        self::defaultTitle($name, $title);

        return TextArea::make($name)
            ->rows(4)
            ->title($title)
            ->horizontal();
    }

    public static function timeZone($name = 'time_zone', $title = null)
    {
        self::defaultTitle($name, $title);

        return TimeZone::make($name)
            ->title($title)
            ->horizontal();
    }

    public static function upload($name = 'attachment', $title = null)
    {
        self::defaultTitle($name, $title);

        return Upload::make($name)
            ->title($title)
            ->horizontal();
    }

    public static function uploadPicture($name = 'attachment', $title = null)
    {
        return self::upload($name, $title)
            ->acceptedFiles('image/*');
    }

    public static function uploadVideo($name = 'attachment', $title = null)
    {
        return self::upload($name, $title)
            ->acceptedFiles('video/*');
    }

    public static function uploadAudio($name = 'attachment', $title = null)
    {
        return self::upload($name, $title)
            ->acceptedFiles('audio/*');
    }

    public static function uploadMedia($name = 'attachment', $title = null)
    {
        return self::upload($name, $title)
            ->acceptedFiles('audio/*,video/*,image/*');
    }

    public static function utm($name = 'utm', $title = null)
    {
        self::defaultTitle($name, $title);

        return UTM::make($name)
            ->title($title)
            ->horizontal();
    }
}
