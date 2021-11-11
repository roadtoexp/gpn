<?php

declare(strict_types=1);

namespace App\Http\Models\Repositories;

use App\Http\Models\Entity\CardType;

interface CardTypeRepository
{
    public function updateOrCreate(array $data): ?CardType;

    public function findById(string $id): ?CardType;
}
