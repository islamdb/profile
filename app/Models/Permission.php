<?php

namespace App\Models;

use App\Support\Traits\ResourceAllowedSortsAndFilters;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * @property varchar $slug slug
 * @property varchar $name name
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Permission extends Model
{
    use AsSource,
        Filterable,
        Attachable,
        ResourceAllowedSortsAndFilters,
        QueryCacheable;

    /**
     * Database table name
     */
    protected $table = 'permissions';

    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'group',
        'slug',
        'name'
    ];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * cache time, in seconds
     *
     * @var float|int
     */
    public $cacheFor = 60 // 1 menit
    * 60 // 1 jam
    * 24 // 1 hari
    * 30; // 1 bulan

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;
}
