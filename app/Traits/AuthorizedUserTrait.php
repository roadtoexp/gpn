<?php

declare(strict_types = 1);

namespace App\Traits;

use App\Models\Entity\User;
use Auth;

trait AuthorizedUserTrait
{
    public function authUser(User $user): bool
    {
        Auth::login($user);

        return Auth::check();
    }

//    public function isCurrentUserByBillId();
//
//    public function isCurrentUserByCardId();
}
