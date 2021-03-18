<?php

namespace App\Models;

use App\Support\RowNumber;
use App\Support\Traits\ResourceAllowedSortsAndFilters;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property text $images images
 * @property varchar $name name
 * @property varchar $slug slug
 * @property text $summary summary
 * @property longtext $body body
 * @property text $meta_title meta title
 * @property text $meta_keywords meta keywords
 * @property text $meta_description meta description
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property \Illuminate\Database\Eloquent\Collection $category belongsToMany
 */
class Portofolio extends Model
{
    use AsSource,
        Filterable,
        Attachable,
        ResourceAllowedSortsAndFilters;

    /**
     * Database table name
     */
    protected $table = 'portofolios';

    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'name',
        'slug',
        'summary',
        'body',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(PortofolioCategory::class, 'portofolio_category');
    }


}
