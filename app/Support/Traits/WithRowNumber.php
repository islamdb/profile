<?php


namespace App\Support\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait WithRowNumber
{
    public function scopeRowNumber(Builder $query, $column = 'created_at', $as = 'rnumber')
    {
        return $query->addSelect(
            DB::raw("row_number() over (order by $column) as $as")
        );
    }
}
