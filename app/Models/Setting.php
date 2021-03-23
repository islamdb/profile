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

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'key',
        'name',
        'editable',
        'type',
        'value'
    ];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
