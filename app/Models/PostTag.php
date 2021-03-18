<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $name name
 * @property varchar $slug slug
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property \Illuminate\Database\Eloquent\Collection $ belongsToMany
 */
class PostTag extends Model
{

    /**
     * Database table name
     */
    protected $table = 'post_tags';

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
     * post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_tag');
    }


}
