<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $name name
 * @property varchar $slug slug
 * @property longtext $description description
 * @property longtext $images images
 * @property longtext $videos videos
 * @property text $meta_title meta title
 * @property text $meta_keywords meta keywords
 * @property text $meta_description meta description
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Gallery extends Model
{

    /**
     * Database table name
     */
    protected $table = 'galleries';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['name',
        'slug',
        'description',
        'images',
        'videos',
        'meta_title',
        'meta_keywords',
        'meta_description'];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
