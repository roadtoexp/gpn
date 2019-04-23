<?php

declare(strict_types=1);

namespace App\Http\Models\Repositories;

use App\Http\Models\Entity\Card;
use Illuminate\Support\Collection;

interface CardRepository
{
    /**
     * @param int $id
     *
     * @return \App\Http\Models\Entity\Card|null
     */
    public function findById(int $id): ?Card;

    /**
     * @param int $id
     *
     * @return \App\Http\Models\Entity\Card|null
     */
    public function findByUserId(int $id): ?Card;

    /**
     * @param array $filter
     * @param int   $offset
     * @param int   $limit
     *
     * @return \Illuminate\Support\Collection
     */
    public function all(array $filter, int $offset = 0, int $limit = 10000): Collection;

    /**
     * @param array $data
     *
     * @return \App\Http\Models\Entity\Card|null
     */
    public function updateOrCreate(array $data): ?Card;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function deleteByUserId(int $id): bool;

    /**
     * @param string $bill
     * @param array  $data
     *
     * @return array
     */
    public function collectCard(string $bill, array $data): array;
}
