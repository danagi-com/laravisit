<?php

namespace Coderflex\Laravisit\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface CanVisit
{
    /**
     * keep track of your pages
     *
     * @param string|null $type
     * @return PendingVisit
     */
    public function visit(?string $type = null): PendingVisit;

    /**
     * Has Visits relationship many to many relationship
     *
     * @param array|null $types
     * @return MorphMany
     */
    public function visits(?array $types = null): MorphMany;
}
