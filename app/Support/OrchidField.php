<?php


namespace App\Support;


use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Upload;

class OrchidField
{
    public static function withMeta(array $fields)
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
            Input::make($referencedName)
                ->title(Str::title($referencedName))
                ->type('text')
                ->maxlength(191)
                ->horizontal()
                ->required(),
            Input::make('slug')
                ->title('Slug')
                ->type('text')
                ->maxlength(191)
                ->help('Boleh dikosongi')
                ->horizontal(),
        ], $fields);
    }

    public static function attachmentImageAndVideo($title = 'Images/Videos')
    {
        return Upload::make('attachment')
            ->title($title)
            ->acceptedFiles('image/*, video/*')
            ->horizontal();
    }

    public static function body()
    {
        return Quill::make('body')
            ->title('Body')
            ->horizontal();
    }
}
