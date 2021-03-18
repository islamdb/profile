<?php

namespace App\Models;

use App\Support\Traits\ResourceAllowedSortsAndFilters;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property varchar $email email
 * @property varchar $no no
 * @property varchar $subject subject
 * @property longtext $body body
 */
class Message extends Model
{
    use AsSource,
        Filterable,
        Attachable,
        ResourceAllowedSortsAndFilters;

    /**
     * Database table name
     */
    protected $table = 'messages';

    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'body'
    ];

    /**
     * Date time columns.
     */
    protected $dates = [];
}
