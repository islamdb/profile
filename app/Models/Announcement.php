<?php

namespace App\Models;

use App\Support\Traits\ResourceAllowedSortsAndFilters;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property varchar $group group
 * @property varchar $slug slug
 * @property varchar $title title
 * @property longtext $body body
 * @property text $meta_title meta title
 * @property text $meta_keywords meta keywords
 * @property text $meta_description meta description
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 */
class Announcement extends Model
{
    use AsSource,
        Filterable,
        Attachable,
        ResourceAllowedSortsAndFilters;

    /**
     * Database table name
     */
    protected $table = 'announcements';

    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'group',
        'slug',
        'title',
        'body',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
