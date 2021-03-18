<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property text $image image
 * @property varchar $title title
 * @property text $description description
 * @property text $url url
 * @property tinyint $url_new_tab url new tab
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Slider extends Model
{

    /**
     * Database table name
     */
    protected $table = 'sliders';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['image',
        'title',
        'description',
        'url',
        'url_new_tab'];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
