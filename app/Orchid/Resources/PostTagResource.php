<?php

namespace App\Orchid\Resources;

use App\Models\PostTag;
use App\Support\MyField;
use App\Support\MyTD;
use App\Support\Traits\ResourceOnSave;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\TD;

class PostTagResource extends Resource
{
    use ResourceOnSave;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PostTag::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return MyField::withSlug('name', MyField::withMeta());
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

    public static function icon(): string
    {
        return 'grid';
    }

    public function onSave(ResourceRequest $request, Model $model)
    {
        $this->sluggable($request, 'name');

        parent::onSave($request, $model);
    }
}
