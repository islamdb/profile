<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property text $image image
 * @property varchar $name name
 * @property text $url url
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Social extends Model
{

    /**
     * Database table name
     */
    protected $table = 'socials';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['image',
        'name',
        'url'];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
