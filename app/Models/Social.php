<?php

namespace App\Models;

use App\Support\Traits\ResourceAllowedSortsAndFilters;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property text $image image
 * @property varchar $name name
 * @property text $url url
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Social extends Model
{
    use AsSource,
        Filterable,
        Attachable,
        ResourceAllowedSortsAndFilters;

    /**
     * Database table name
     */
    protected $table = 'socials';

    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'image',
        'name',
        'url'
    ];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
