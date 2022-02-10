<?php

namespace Coderflex\Laravisit\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * Filter By Popularity Time Frame
 */
trait FilterByPopularityTimeFrame
{
    /**
     * Get the total visit count
     * 
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithTotalVisitCount(Builder $builder)
    {
        $builder->withCount('visits as visit_count_total');
    }
}
