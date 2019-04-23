<?php

declare(strict_types=1);

namespace App\Http\Models\Repositories;

use App\Http\Models\Entity\CardType;

class EloquentCardTypeRepository implements CardTypeRepository
{
    private $billStatus;

    public function __construct(CardType $billStatus)
    {
        $this->billStatus = $billStatus;
    }

    public function findById(string $id): ?CardType
    {
        return $this->billStatus
            ->where('id', $id)
            ->first();
    }

    public function updateOrCreate(array $data): ?CardType
    {
        return $this->billStatus
            ->updateOrCreate(['id' => $data['id']], $data);
    }
}
