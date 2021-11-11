<?php

declare(strict_types=1);

namespace App\Http\Models\Repositories;

use App\Http\Models\Entity\Bill;

class EloquentBillRepository implements BillRepository
{
    /** @var \App\Http\Models\Entity\Bill */
    private $bill;

    /** @var \App\Http\Models\Repositories\BillStatusRepository */
    private $billStatusRepository;

    /** @var \App\Http\Models\Repositories\UserRepository */
    private $userRepository;

    /**
     * EloquentBillRepository constructor.
     *
     * @param \App\Http\Models\Entity\Bill                       $bill
     * @param \App\Http\Models\Repositories\BillStatusRepository $billStatusRepository
     * @param \App\Http\Models\Repositories\UserRepository       $userRepository
     */
    public function __construct(
        Bill $bill,
        BillStatusRepository $billStatusRepository,
        UserRepository $userRepository
    ) {
        $this->bill = $bill;
        $this->billStatusRepository = $billStatusRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function findById(string $id): ?Bill
    {
        return $this->bill
            ->where('id', $id)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findByUserId(int $id): ?Bill
    {
        return $this->bill
            ->where('user_id', $id)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function updateOrCreate(array $data): ?Bill
    {
        return $this->bill
            ->updateOrCreate(['id' => $data['id']], $data);
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
    public function deleteByUserId(int $id): bool
    {
        $delete = $this
            ->findByUserId($id)
            ->delete();

        return boolval($delete);
    }

    /**
     * {@inheritdoc}
     *
     * @todo:
     *      Не корректно напрямую обращаться к свойству которого может не быть.
     *      Я бы использовал паттерн DDD, но тогда эта задача слишком растянется.
     */
    public function collectBill(string $user, array $data): array
    {
        return [
            'id'        => $data['id'],
            'number'    => $data['number'],
            'user_id'   => $this->userRepository->findByLogin($user)->id,
            'status_id' => $this->billStatusRepository->findById($data['status'])->id,
        ];
    }
}
