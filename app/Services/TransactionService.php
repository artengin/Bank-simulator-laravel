<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use RonasIT\Support\Services\EntityService;
use App\APIServices\BankApiService;
use App\Enums\Transactions\TypeEnum;
use App\Support\Arr;

/**
 * @mixin TransactionRepository
 * @property TransactionRepository $repository
 */
class TransactionService extends EntityService
{
    public function __construct(
        protected BankApiService $bankApiService,
    ) {
        $this->setRepository(TransactionRepository::class);
    }

    public function simulate(array $data, TypeEnum $type): Transaction
    {
        $data['type'] = $type;
        $data['name'] = $data['name'] ?? Arr::random(config('defaults.transaction_names'));

        $transaction = $this->create($data);

        $this->bankApiService->sendTransactionWebhook($transaction);

        return $transaction;
    }
}
