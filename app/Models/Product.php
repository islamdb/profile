<?php

namespace App\Models;

use App\Support\Traits\ResourceAllowedSortsAndFilters;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property varchar $name name
 * @property varchar $slug slug
 * @property decimal $price price
 * @property decimal $discount discount
 * @property longtext $body body
 * @property text $meta_title meta title
 * @property text $meta_keywords meta keywords
 * @property text $meta_description meta description
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property \Illuminate\Database\Eloquent\Collection $category belongsToMany
 */
class Product extends Model
{
    use AsSource,
        Filterable,
        Attachable,
        ResourceAllowedSortsAndFilters;

    /**
     * Database table name
     */
    protected $table = 'products';

    /**
     * Mass assignable columns
     */
    protected $fillable = [
        'name',
        'slug',
        'active',
        'price',
        'discount',
        'body',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];

    /**
     * Date time columns.
     */
    protected $dates = [];

    protected $casts = [
        'price' => 'float',
        'discount' => 'float'
    ];

    /**
     * categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_category');
    }

    public function getDiscountPresentageAttribute()
    {
        return $this->discount / $this->price * 100;
    }
}
