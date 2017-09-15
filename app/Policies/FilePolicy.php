<?php

namespace App\Policies;

use App\File;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Checks wether the user has the right to access the resource.
     *
     * @param User $user
     * @param File $file
     * @return bool
     */
    public function touch(User $user, File $file)
    {
        return $user->id === $file->user_id;
    }
}
