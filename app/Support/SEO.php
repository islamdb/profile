<?php


namespace App\Support;


use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

class SEO
{
    public static function metaColumns(Blueprint $table)
    {
        $table->text('meta_title')
            ->nullable();
        $table->text('meta_keywords')
            ->nullable();
        $table->text('meta_description')
            ->nullable();
    }

    public static function default(string $title = '', string $desc = '', string $canonical = '', bool $formatTitle = true)
    {
        $title = $formatTitle
            ? ucwords(Str::slug($title, ' '))
            : $title;
        $desc = Str::slug($desc, ' ');

        // default seo
        SEOMeta::setKeywords([
            'islamdb',
            translate('referensi islami', 'id'),
            translate('ensiklopedi islam', 'id')
        ]);
        SEOMeta::addAlternateLanguage('id-id', route('lang', ['id' => 'id']));
        SEOMeta::addAlternateLanguage('en-us', route('lang', ['id' => 'en']));
        SEOMeta::addAlternateLanguage('ar-ae', route('lang', ['id' => 'ar']));
        OpenGraph::setUrl(url()->current());
        OpenGraph::setSiteName(config('app.name'));
        OpenGraph::addProperty('type', translate('referensi', 'id'));
        OpenGraph::addProperty('locale', 'id-id');
        OpenGraph::addProperty('locale:alternate', ['en-us', 'ar-ae']);
        TwitterCard::setUrl(url()->current());
        JsonLd::setImages([asset('idb.png')]);
        JsonLd::setType(translate('Referensi', 'id'));

        SEOMeta::setTitle($title);
        OpenGraph::setTitle($title);
        SEOMeta::setDescription($desc);
        OpenGraph::setDescription($desc);
        SEOMeta::setCanonical($canonical);
    }
}
