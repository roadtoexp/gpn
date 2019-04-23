<?php

declare(strict_types=1);

namespace App\Http\Models\Repositories;

use App\Models\Entity\User;

interface UserRepository
{
    /**
     * @param int $id
     *
     * @return \App\Models\Entity\User|null
     */
    public function findById(int $id): ?User;

    /**
     * @param string $login
     *
     * @return \App\Models\Entity\User|null
     */
    public function findByLogin(string $login): ?User;

    /**
     * @param array $data
     *
     * @return \App\Models\Entity\User|null
     */
    public function updateOrCreate(array $data): ?User;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * @param string $login
     *
     * @return bool
     */
    public function deleteByLogin(string $login): bool;
}
