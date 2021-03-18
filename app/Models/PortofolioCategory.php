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
 * @property varchar $slug slug
 * @property text $description description
 * @property text $meta_title meta title
 * @property text $meta_keywords meta keywords
 * @property text $meta_description meta description
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property \Illuminate\Database\Eloquent\Collection $ belongsToMany
 */
class PortofolioCategory extends Model
{
    use AsSource,
        Filterable,
        Attachable,
        ResourceAllowedSortsAndFilters;

    /**
     * Database table name
     */
    protected $table = 'portofolio_categories';

    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * portofolios
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function portofolios()
    {
        return $this->belongsToMany(Portofolio::class,'portofolio_category');
    }


}
