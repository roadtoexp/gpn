<?php

declare(strict_types=1);

namespace App\Http\Models\Repositories;

use App\Http\Models\Entity\Bill;

interface BillRepository
{
    /**
     * @param string $id
     *
     * @return \App\Http\Models\Entity\Bill|null
     */
    public function findById(string $id): ?Bill;

    /**
     * @param int $id
     *
     * @return \App\Http\Models\Entity\Bill|null
     */
    public function findByUserId(int $id): ?Bill;

    /**
     * @param array $data
     *
     * @return \App\Http\Models\Entity\Bill|null
     */
    public function updateOrCreate(array $data): ?Bill;

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
     * @param string $user
     * @param array  $data
     *
     * @return array
     */
    public function collectBill(string $user, array $data): array;
}
