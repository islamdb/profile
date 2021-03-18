<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property varchar $email email
 * @property varchar $no no
 * @property varchar $subject subject
 * @property longtext $body body
 */
class Message extends Model
{

    /**
     * Database table name
     */
    protected $table = 'messages';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['name',
        'email',
        'no',
        'subject',
        'body'];

    /**
     * Date time columns.
     */
    protected $dates = [];


}
