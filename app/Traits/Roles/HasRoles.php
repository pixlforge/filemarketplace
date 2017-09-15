<?php

namespace App\Traits\Roles;

use App\Role;

trait HasRoles
{
    /**
     * Checks wether the user is associated with a specific role.
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (! $this->roles->contains('name', $role)) {
            return false;
        }

        return true;
    }

    /**
     * Relation to Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }
}