<?php

declare(strict_types = 1);

namespace App\Http\Models\Repositories;

use App\Http\Models\Entity\Session;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EloquentSessionRepository implements SessionRepository
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function findOld(Carbon $date): ?Collection
    {
        return $this->session
            ->where('last_activity', '<=', $date->timestamp)
            ->get();
    }
}
