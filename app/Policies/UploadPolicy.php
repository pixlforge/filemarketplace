<?php

namespace App\Policies;

use App\User;
use App\Upload;
use Illuminate\Auth\Access\HandlesAuthorization;

class UploadPolicy
{
    use HandlesAuthorization;

    /**
     * Checks wether the user has the right to access the resource.
     *
     * @param User $user
     * @param Upload $upload
     * @return bool
     */
    public function touch(User $user, Upload $upload)
    {
        return $user->id === $upload->user_id;
    }
}
