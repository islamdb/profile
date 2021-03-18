<?php

namespace App\Models;

use App\Support\Traits\ResourceAllowedSortsAndFilters;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property bigint unsigned $user_id user id
 * @property text $image image
 * @property varchar $title title
 * @property varchar $slug slug
 * @property text $summary summary
 * @property longtext $body body
 * @property text $meta_title meta title
 * @property text $meta_keywords meta keywords
 * @property text $meta_description meta description
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property User $user belongsTo
 * @property \Illuminate\Database\Eloquent\Collection $category belongsToMany
 * @property \Illuminate\Database\Eloquent\Collection $tag belongsToMany
 */
class Post extends Model
{
    use AsSource,
        Filterable,
        Attachable,
        ResourceAllowedSortsAndFilters;

    /**
     * Database table name
     */
    protected $table = 'posts';

    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'user_id',
        'image',
        'title',
        'slug',
        'summary',
        'body',
        'published_at',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(PostCategory::class, 'post_category');
    }

    /**
     * tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(PostTag::class, 'post_tag');
    }


}
