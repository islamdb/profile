<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property text $images images
 * @property varchar $name name
 * @property varchar $slug slug
 * @property text $summary summary
 * @property longtext $body body
 * @property text $meta_title meta title
 * @property text $meta_keywords meta keywords
 * @property text $meta_description meta description
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Portofolio extends Model
{

    /**
     * Database table name
     */
    protected $table = 'portofolios';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['images',
        'name',
        'slug',
        'summary',
        'body',
        'meta_title',
        'meta_keywords',
        'meta_description'];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
