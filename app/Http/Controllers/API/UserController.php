<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Models\Repositories\UserRepository;
use App\Http\Requests\API\UserRequest;
use App\Traits\AuthorizedUserTrait;
use App\Traits\GettingResponseTrait;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

/**
 * Class UserController.
 */
final class UserController extends Controller
{
    use AuthorizedUserTrait;
    use GettingResponseTrait;

    /** @var \App\Http\Models\Repositories\UserRepository */
    private $userRepository;
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * UserController constructor.
     *
     * @param \App\Http\Models\Repositories\UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->client = new Client([
            'base_uri' => env('API_URL', ''),
            'verify'   => false,
        ]);

        $this->userRepository = $userRepository;
    }

    /**
     * @param \App\Http\Requests\API\UserRequest $userRequest
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth(UserRequest $userRequest): JsonResponse
    {
        try {
            $response = $this->client->post('Auth', [
                'form_params' => $userRequest->only(['login', 'password']),
            ]);

            $response = $this->getResponse($response);

            $this->authUser(
                $this->userRepository
                    ->updateOrCreate($userRequest->all())
            );
        } catch (\Exception $exception) {
            $response = [
                'Response'     => false,
                'ErrorCode'    => $exception->getCode(),
                'ErrorMessage' => 'Invalid credentials',
            ];
        }

        return response()
            ->json([
                'response'     => $response['Response'],
                'errorcode'    => $response['ErrorCode'],
                'errormessage' => $response['ErrorMessage'],
            ]);
    }
}
