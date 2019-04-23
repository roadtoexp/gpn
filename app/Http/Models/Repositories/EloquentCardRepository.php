<?php

declare(strict_types=1);

namespace App\Http\Models\Repositories;

use App\Http\Models\Entity\Card;
use Illuminate\Support\Collection;

class EloquentCardRepository implements CardRepository
{
    private $card;
    private $cardTypeRepository;
    private $billRepository;

    public function __construct(
        Card $card,
        CardTypeRepository $cardTypeRepository,
        BillRepository $billRepository
    )
    {
        $this->card = $card;
        $this->cardTypeRepository = $cardTypeRepository;
        $this->billRepository = $billRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function findById(int $id): ?Card
    {
        return $this->card
            ->where('id', $id)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function findByUserId(int $id): ?Card
    {
        return $this->card
            ->where('user_id', $id)
            ->first();
    }

    public function all(array $filter, int $offset = 0, int $limit = 10000): Collection
    {
        dump($filter, $offset, $limit);
        return $this->card
            ->where($filter)
            ->skip($offset)
            ->take($limit)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function updateOrCreate(array $data): ?Card
    {
        return $this->card
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
     * @todo:
     *      Не совсем корректно напрямую обращаться к свойству которого может не быть.
     *      Я бы использовал паттерн DDD, но тогда эта задача слишком растянется.
     */
    public function collectCard(string $bill, array $data): array
    {
        return [
            'id' => $data['id'],
            'bill_id' => $this->billRepository->findById($bill)->id,
            'type_id' => $this->cardTypeRepository->findById($data['type'])->id,
            'number' => $data['number'],
            'active' => $data['active'],
            'balance' => $data['balance'] ?? null,
            'last_usage' => $data['last_usage'] ?? null,
            'description' => $data['description'] ?? '',
        ];
    }
}
