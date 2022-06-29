<?php

namespace Coderflex\Laravisit\Concerns;

use Coderflex\Laravisit\Exceptions\VisitException;
use Coderflex\Laravisit\Models\Visit;
use Coderflex\Laravisit\PendingVisit;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Has Visits Relation
 */
trait HasVisits
{
    use FilterByPopularityTimeFrame;

    /**
     * keep track of your pages
     *
     * @param string|null $type
     * @return PendingVisit
     * @throws VisitException
     */
    public function visit(?string $type = null): PendingVisit
    {
        return new PendingVisit($this, $type ?? $this->getDefaultVisitType());
    }

    /**
     * Has Visits relationship many to many relationship
     *
     * @param array|null $types
     * @return MorphMany
     */
    public function visits(?array $types = []): MorphMany
    {
        return $this->morphMany(Visit::class, 'visitable')
            ->whereIn('type', $types ?? $this->getDefaultVisitTypes());
    }
}
