<?php

declare(strict_types=1);

namespace App\Http\Requests\API;

use App\Request\APIFormRequest;

final class CardRequest extends APIFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id_bill' => 'string|exists:bills,id',
            'id_card' => 'string|exists:cards,id',
        ];
    }
}
