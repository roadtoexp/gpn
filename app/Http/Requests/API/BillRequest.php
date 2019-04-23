<?php

declare(strict_types=1);

namespace App\Http\Requests\API;

use App\Request\APIFormRequest;

final class BillRequest extends APIFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string|exists:users,login',
        ];
    }
}
