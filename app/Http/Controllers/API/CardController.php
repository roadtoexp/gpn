<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Models\Repositories\BillRepository;
use App\Http\Models\Repositories\CardRepository;
use App\Http\Requests\API\CardRequest;
use App\Traits\AuthorizedUserTrait;
use App\Traits\GettingResponseTrait;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

final class CardController extends Controller
{
    use GettingResponseTrait;
    use AuthorizedUserTrait;

    private $client;

    /** @var \App\Http\Models\Repositories\BillRepository */
    private $billRepository;
    /** @var \App\Http\Models\Repositories\CardRepository */
    private $cardRepository;

    /**
     * CardController constructor.
     *
     * @param \App\Http\Models\Repositories\BillRepository $billRepository
     * @param \App\Http\Models\Repositories\CardRepository $cardRepository
     */
    public function __construct(BillRepository $billRepository, CardRepository $cardRepository)
    {
        $this->billRepository = $billRepository;
        $this->cardRepository = $cardRepository;

        $this->client = new Client([
            'base_uri' => env('API_URL', ''),
            'verify'   => false,
        ]);
    }

    public function listCards(CardRequest $cardRequest): JsonResponse
    {
        if ($this->isCurrentUserByBillId($cardRequest->get('id_bill'))) {
            try {
                $response = $this->client
                    ->get('Cards', [
                        'query' => $cardRequest->only('id_bill'),
                    ]);

                $response = $this->getResponse($response);

                foreach ($response['Response']['Card'] as $card) {
                    $this->cardRepository->updateOrCreate(
                        $this->cardRepository->collectCard($cardRequest->get('id_bill'), $card)
                    );
                }
            } catch (Exception $exception) {
                $response = false;
                $errorCode = $exception->getCode();
                $errorMessage = $exception->getMessage();
            }
        }

        return response()->json([
            'response' => $this->cardRepository->all(
                $cardRequest->get('filter', []),
                $cardRequest->get('offset', 0),
                $cardRequest->get('limit', 10000)
            ),
            'errorcode'    => $errorCode ?? false,
            'errormessage' => $errorMessage ?? null,
        ]);
    }

    public function show(CardRequest $cardRequest)
    {
        try {
            $response = $this->client
                ->get('CardDetail', [
                    'query' => $cardRequest->only('id_card'),
                ]);

            $response = $this->getResponse($response);

            $this->cardRepository->updateOrCreate(
                $this->cardRepository->collectCard(
                    $response['Response']['bill_id'],
                    $response['Response']
                )
            );
        } catch (Exception $exception) {
            $response = false;
            $errorCode = $exception->getCode();
            $errorMessage = $exception->getMessage();
        }

        return response()->json([
            'response'     => $this->cardRepository->findById((int) $cardRequest->get('id_card')),
            'errorcode'    => $errorCode ?? false,
            'errormessage' => $errorMessage ?? null,
        ]);
    }
}
