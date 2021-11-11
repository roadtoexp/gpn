<?php

declare(strict_types=1);

namespace App\Http\Models\Repositories;

use App\Http\Models\Entity\BillStatus;

interface BillStatusRepository
{
    public function updateOrCreate(array $data): ?BillStatus;

    public function findById(string $id): ?BillStatus;
}
