<?php

declare(strict_types = 1);

namespace App\Http\Models\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface SessionRepository
{
    public function findOld(Carbon $date): ?Collection;
}
