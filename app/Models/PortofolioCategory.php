<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    /**
     * Database table name
     */
    protected $table = 'portofolio_categories';

    /**
     * Mass assignable columns
     */
    protected $fillable = ['image',
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description'];

    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function portofolios()
    {
        return $this->belongsToMany(Portofolio::class,'portofolio_category');
    }


}
