<?php

namespace App\Orchid\Resources;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Orchid\Actions\DeleteAction;
use App\Support\MyField;
use App\Support\MyTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\TD;

class PostResource extends Resource
{
    use ResourceOnSave;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Post::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return MyField::withSlug('title', MyField::withMeta([
            MyField::uploadPicture('attachment', 'Cover'),
            MyField::select('categories.')
                ->fromModel(PostCategory::class, 'name')
                ->multiple(),
            MyField::textArea('summary'),
            MyField::quill('body'),
            MyField::select('tags.')
                ->fromModel(PostTag::class, 'name')
                ->multiple(),
            MyField::dateTimer('published_at')
        ]));
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
            TD::make('categories')
                ->render(function ($model) {
                    return $model->categories
                        ->pluck('name')
                        ->map(function ($name) {
                            return badge($name);
                        })
                        ->join('&nbsp;');
                }),
            TD::make('tags')
                ->render(function ($model) {
                    return $model->tags
                        ->pluck('name')
                        ->map(function ($name) {
                            return badge($name);
                        })
                        ->join('&nbsp;');
                }),
            MyTD::dateTime('published_at'),
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

    public function with(): array
    {
        return [
            'tags' => function ($q) {
                $q->select(['id', 'name']);
            },
            'categories' => function ($q) {
                $q->select(['id', 'name']);
            }
        ];
    }

    public static function icon(): string
    {
        return 'screen-tablet';
    }

    public function onSave(ResourceRequest $request, Model $model)
    {
        $this->sluggable($request);

        $categories = $request->categories;
        $tags = $request->tags;

        $request->request
            ->remove('categories');
        $request->request
            ->remove('tags');

        DB::beginTransaction();

        $this->saveWithAttachment($request, $model);

        $model->categories()
            ->detach();
        $model->categories()
            ->attach($categories);

        $model->tags()
            ->detach();
        $model->tags()
            ->attach($tags);

        DB::commit();
    }
}
