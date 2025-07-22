<?php

namespace Tests\Support;

use Illuminate\Http\Response;

trait BankMockTrait
{
    use BaseMockTrait;

    protected function webhookTransactions(array $requestData, int $statusCode = Response::HTTP_OK): array
    {
        return $this->bankRequest('POST', '/webhook/transactions', $requestData, $statusCode);
    }

    protected function bankRequest(
        string $type,
        string $uri,
        array $requestData = [],
        int $statusCode = Response::HTTP_OK,
    ): array {
        return $this->request(
            type: $type,
            url: config('services.pillar_bank.url') . "{$uri}",
            data: $requestData,
            headers: [
                'authorization' => config('services.pillar_bank.token_secret'),
                'content-type' => 'application/json',
                'accept' => 'application/json',
            ],
            options: [
                'http_errors' => false,
            ],
            statusCode: $statusCode,
        );
    }
}
