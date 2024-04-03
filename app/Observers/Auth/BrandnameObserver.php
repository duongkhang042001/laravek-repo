<?php

namespace App\Observers\Auth;

use App\Models\Brandname\Brandname;

class BrandnameObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(Brandname $brandname): void
    {
        $brandname->enabled = 0; //tất cả tài khoản được tạo ra đều là admin
    }
}
