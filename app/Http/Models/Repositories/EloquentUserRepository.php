<?php

declare(strict_types=1);

namespace App\Http\Models\Repositories;

use App\Models\Entity\User;

class EloquentUserRepository implements UserRepository
{
    /** @var \App\Models\Entity\User $user */
    private $user;

    /**
     * EloquentUserRepository constructor.
     *
     * @param \App\Models\Entity\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function findById(int $id): ?User
    {
        return $this->user
            ->with('bills')
            ->where('id', $id)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findByLogin(string $login): ?User
    {
        return $this->user
            ->with('bills')
            ->where('login', $login)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function updateOrCreate(array $data): ?User
    {
        return $this->user
            ->updateOrCreate(['login' => $data['login']], $data);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById(int $id): bool
    {
        $delete = $this
            ->findById($id)
            ->delete();

        return boolval($delete);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteByLogin(string $login): bool
    {
        $delete = $this
            ->findByLogin($login)
            ->delete();

        return boolval($delete);
    }
}
