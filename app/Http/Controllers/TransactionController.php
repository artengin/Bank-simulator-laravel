<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\SimulateTransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\Response;
use App\Enums\Transactions\TypeEnum;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {
    }

    public function simulate(SimulateTransactionRequest $request, string $type): Response
    {
        $data = $request->onlyValidated();
        $data['initializer_id'] = $request->user()->id;

        $this->transactionService->simulate($data, TypeEnum::from($type));

        return response('', Response::HTTP_NO_CONTENT);
    }
}
