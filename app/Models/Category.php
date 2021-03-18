<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property text $image image
 * @property varchar $name name
 * @property varchar $slug slug
 * @property text $description description
 * @property text $meta_title meta title
 * @property text $meta_keywords meta keywords
 * @property text $meta_description meta description
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property \Illuminate\Database\Eloquent\Collection $post belongsToMany
 */
class Category extends Model
{

    /**
     * Database table name
     */
    protected $table = 'categories';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['image',
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category');
    }


}
