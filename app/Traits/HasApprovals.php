<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasApprovals
{
    /**
     * ScopeApproved.
     *
     * @param Builder $builder
     * @return $this
     */
    public function scopeApproved(Builder $builder)
    {
        return $builder->where('approved', true);
    }

    /**
     * Scope Unapproved.
     *
     * @param Builder $builder
     * @return $this
     */
    public function scopeUnapproved(Builder $builder)
    {
        return $builder->where('approved', false);
    }
}