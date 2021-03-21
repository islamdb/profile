<?php

namespace App\Orchid\Resources;

use App\Models\PostCategory;
use App\Orchid\Actions\DeleteAction;
use App\Support\MyField;
use App\Support\MyTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\TD;

class PostCategoryResource extends Resource
{
    use ResourceOnSave;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PostCategory::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return MyField::withSlug('name', MyField::withMeta([
            MyField::uploadPicture('attachment', 'Logo/Icon'),
            MyField::textArea('description')
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
            MyTD::name(),
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

    public static function icon(): string
    {
        return 'table';
    }

    public function onSave(ResourceRequest $request, Model $model)
    {
        $this->sluggable($request, 'name');

        $this->saveWithAttachment($request, $model);
    }
}
