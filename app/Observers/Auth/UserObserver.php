<?php

namespace App\Observers\Auth;

use App\Models\Auth\User;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        $user->is_admin = 1; //tất cả tài khoản được tạo ra đều là admin
    }

    /**
     * Handle the User "updating" event.
     */
    public function updating(User $user): void
    {
        $user->updated_by = null;
    }
}
