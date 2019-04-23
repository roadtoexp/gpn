<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Models\Repositories\BillRepository;
use App\Http\Models\Repositories\UserRepository;
use App\Traits\AuthorizedUserTrait;
use App\Traits\GettingResponseTrait;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\BillRequest;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

final class BillController extends Controller
{
    use GettingResponseTrait;
    use AuthorizedUserTrait;

    private $client;

    /** @var \App\Http\Models\Repositories\UserRepository $userRepository */
    private $userRepository;
    /** @var \App\Http\Models\Repositories\BillRepository $billRepository */
    private $billRepository;

    /**
     * BillController constructor.
     *
     * @param \App\Http\Models\Repositories\UserRepository $userRepository
     * @param \App\Http\Models\Repositories\BillRepository $billRepository
     */
    public function __construct(UserRepository $userRepository, BillRepository $billRepository)
    {
        $this->userRepository = $userRepository;
        $this->billRepository = $billRepository;

        $this->client = new Client([
            'base_uri' => env('API_URL', ''),
            'verify' => false
        ]);
    }

    public function listBills(BillRequest $billRequest): JsonResponse
    {
        if ($this->isCurrentUserByUserLogin($billRequest->get('login'))) {
            try {
                $response = $this->client
                    ->get('Bills', [
                        'query' => $billRequest->only('login')
                    ]);

                $response = $this->getResponse($response);

                foreach ($response['Response']['Bill'] as $bill) {
                    $this->billRepository->updateOrCreate(
                        $this->billRepository->collectBill($billRequest->get('login'), $bill)
                    );
                }
            } catch (Exception $exception) {
                $response = [
                    'Response' => false,
                    'ErrorCode' => $exception->getCode(),
                    'ErrorMessage' => $exception->getMessage()
                ];
            }
        }

        return response()
            ->json([
                'response' => $response['Response'] ?? $this->userRepository->findByLogin($billRequest->post('login'))->bills,
                'errorcode' => $response['ErrorCode'] ?? 0,
                'errormessage' => $response['ErrorMessage'] ?? ''
            ]);
    }
}
