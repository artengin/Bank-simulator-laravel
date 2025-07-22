<?php

namespace App\Http\Requests\Transaction;

use App\Http\Requests\Request;

class SimulateTransactionRequest extends Request
{
    public function rules(): array
    {
        return [
            'card_number' => 'required|integer|digits:16',
            'amount' => 'required|integer|min:0',
            'name' => 'filled|string'
        ];
    }
}
