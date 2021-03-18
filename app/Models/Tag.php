<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $name name
 * @property varchar $slug slug
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property \Illuminate\Database\Eloquent\Collection $post belongsToMany
 */
class Tag extends Model
{

    /**
     * Database table name
     */
    protected $table = 'tags';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['name',
        'slug'];

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
        return $this->belongsToMany(Post::class, 'post_tag');
    }


}
