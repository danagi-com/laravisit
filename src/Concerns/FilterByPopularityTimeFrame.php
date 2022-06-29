<?php

namespace Coderflex\Laravisit\Concerns;

use Carbon\Carbon;
use Closure;
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
     * @param array|null $types
     * @return Builder
     */
    public function scopeWithTotalVisitCount(Builder $builder, ?array $types = null): Builder
    {
        return $builder->withCount('visits as visit_count_total')
            ->whereIn('type', $types ?? $this->getDefaultVisitTypes());
    }

    /**
     * Get the popular visits all time
     *
     * @param Builder $builder
     * @param array|null $types
     * @return Builder
     */
    public function scopePopularAllTime(Builder $builder, ?array $types = null): Builder
    {
        return $builder->withTotalVisitCount($types)
            ->orderBy('visit_count_total', 'desc');
    }

    /**
     * Get the popular visits today
     *
     * @param Builder $builder
     * @param array|null $types
     * @return Builder
     */
    public function scopePopularToday(Builder $builder, ?array $types = null): Builder
    {
        return $builder->popularBetween(
            now()->startOfDay(),
            now()->endOfDay(),
            $types
        );
    }

    /**
     * Get the popular visits last given days
     *
     * @param Builder $builder
     * @param int $days
     * @param array|null $types
     * @return Builder
     */
    public function scopePopularLastDays(Builder $builder, int $days, ?array $types = null): Builder
    {
        return $builder->popularBetween(
            now()->subDays($days),
            now(),
            $types
        );
    }

    /**
     * Get the popular visits this week
     *
     * @param Builder $builder
     * @param array|null $types
     * @return Builder
     */
    public function scopePopularThisWeek(Builder $builder, ?array $types = null): Builder
    {
        return $builder->popularBetween(
            now()->startOfWeek(),
            now()->endOfWeek(),
            $types
        );
    }

    /**
     * Get the popular visits last week
     *
     * @param Builder $builder
     * @param array|null $types
     * @return Builder
     */
    public function scopePopularLastWeek(Builder $builder, ?array $types = null): Builder
    {
        return $builder->popularBetween(
            $startOfLastWeek = now()->subDay(7)->startOfWeek(),
            $startOfLastWeek->copy()->endOfWeek(),
            $types
        );
    }

    /**
     * Get the popular visits this month
     *
     * @param Builder $builder
     * @param array|null $types
     * @return Builder
     */
    public function scopePopularThisMonth(Builder $builder, ?array $types = null): Builder
    {
        return $builder->popularBetween(
            now()->startOfMonth(),
            now()->endOfMonth(),
            $types
        );
    }

    /**
     * Get the popular visits last month
     *
     * @param Builder $builder
     * @param array|null $types
     * @return Builder
     */
    public function scopePopularLastMonth(Builder $builder, ?array $types = null): Builder
    {
        return $builder->popularBetween(
            now()->startOfMonth()->subMonthWithoutOverflow(),
            now()->subMonthWithoutOverflow()->endOfMonth(),
            $types
        );
    }

    /**
     * Get the popular visits this year
     *
     * @param Builder $builder
     * @param array|null $types
     * @return Builder
     */
    public function scopePopularThisYear(Builder $builder, ?array $types = null): Builder
    {
        return $builder->popularBetween(
            now()->startOfYear(),
            now()->endOfYear(),
            $types
        );
    }

    /**
     * Get the popular visits last year
     *
     * @param Builder $builder
     * @param array|null $types
     * @return Builder
     */
    public function scopePopularLastYear(Builder $builder, ?array $types = null): Builder
    {
        return $builder->popularBetween(
            now()->startOfYear()->subYearWithoutOverflow(),
            now()->subYearWithoutOverflow()->endOfYear(),
            $types
        );
    }

    /**
     * Get the popular visits between two dates
     *
     * @param Builder $builder
     * @param Carbon $from
     * @param Carbon $to
     * @return Builder
     */
    public function scopePopularBetween(Builder $builder, Carbon $from, Carbon $to, ?array $types = null): Builder
    {
        return $builder->whereHas('visits', $this->betweenScope($from, $to))
            ->withCount([
                'visits as visit_count_total' => $this->betweenScope($from, $to),
            ])
            ->whereIn('type', $types ?? $this->getDefaultVisitTypes());
    }

    /**
     * Get the popular visits between two dates
     *
     * @param Carbon $from
     * @param Carbon $to
     * @return Closure
     */
    protected function betweenScope(Carbon $from, Carbon $to): Closure
    {
        return fn ($query) => $query->whereBetween('created_at', [$from, $to]);
    }

    /**
     * Returns the default value for the type of visits.
     * Usually this is the first value of the visit types from the configuration.
     *
     * @return string
     */
    protected function getDefaultVisitType(): string
    {
        return config('laravisit.visit_types')[0];
    }

    /**
     * Returns the default values for the types of visits.
     * Usually this is the first value of the visit types from the configuration.
     *
     * @return array
     */
    protected function getDefaultVisitTypes(): array
    {
        return [$this->getDefaultVisitType()];
    }
}
