<?php

declare(strict_types=1);

namespace App\Traits;

use App\Http\Models\Entity\Bill;
use App\Models\Entity\User;
use Auth;

trait AuthorizedUserTrait
{
    public function authUser(User $user): bool
    {
        Auth::login($user);

        return Auth::check();
    }

    public function isCurrentUserByUserLogin(string $userLogin)
    {
        $user = User::where('login', $userLogin)->first();

        return Auth::user() === $user;
    }

    public function isCurrentUserByBillId(string $billId)
    {
        $user = Bill::where('id', $billId)->first()->user;

        return Auth::user() === $user;
    }
}
