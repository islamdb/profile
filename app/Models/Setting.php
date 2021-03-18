<?php

namespace App\Models;

use App\Support\Traits\ResourceAllowedSortsAndFilters;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property varchar $name name
 * @property varchar $type type
 * @property tinyint $editable editable
 * @property longtext $value value
 */
class Setting extends Model
{
    use AsSource,
        Filterable,
        Attachable,
        ResourceAllowedSortsAndFilters;

    /**
     * Database table name
     */
    protected $table = 'settings';

    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'name',
        'type',
        'editable',
        'value'
    ];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
