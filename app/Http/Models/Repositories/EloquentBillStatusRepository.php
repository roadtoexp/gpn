<?php

declare(strict_types=1);

namespace App\Http\Models\Repositories;

use App\Http\Models\Entity\BillStatus;

class EloquentBillStatusRepository implements BillStatusRepository
{
    private $billStatus;

    public function __construct(BillStatus $billStatus)
    {
        $this->billStatus = $billStatus;
    }

    public function findById(string $id): ?BillStatus
    {
        return $this->billStatus
            ->where('id', $id)
            ->first();
    }

    public function updateOrCreate(array $data): ?BillStatus
    {
        return $this->billStatus
            ->updateOrCreate(['id' => $data['id']], $data);
    }
}
