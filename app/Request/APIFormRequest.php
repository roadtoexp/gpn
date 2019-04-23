<?php

declare(strict_types=1);

namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class APIFormRequest extends FormRequest
{
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()
            ->json(
                [
                    'response' => false,
                    'errorcode' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                    'errormessage' => $errors
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            ));
    }
}
