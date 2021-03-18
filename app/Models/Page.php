<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property text $image image
 * @property varchar $title title
 * @property varchar $slug slug
 * @property tinyint $main main
 * @property longtext $body body
 * @property text $meta_title meta title
 * @property text $meta_keywords meta keywords
 * @property text $meta_description meta description
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Page extends Model
{

    /**
     * Database table name
     */
    protected $table = 'pages';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['image',
        'title',
        'slug',
        'main',
        'body',
        'meta_title',
        'meta_keywords',
        'meta_description'];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
