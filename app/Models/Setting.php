<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $name name
 * @property varchar $type type
 * @property tinyint $editable editable
 * @property longtext $value value
 */
class Setting extends Model
{

    /**
     * Database table name
     */
    protected $table = 'settings';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['value',
        'name',
        'type',
        'editable',
        'value'];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
