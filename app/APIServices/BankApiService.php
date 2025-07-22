<?php

namespace App\APIServices;

use App\Models\Transaction;
use App\Exceptions\ExternalApiHttpException;
use Illuminate\Support\Facades\Hash;
use RonasIT\Support\Services\HttpRequestService;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\ApiServiceEnum;

class BankApiService
{
    protected string $url;
    protected string $token;

    public function __construct(
        protected HttpRequestService $httpRequestService,
    ) {
        $this->url = config('services.pillar_bank.url');
        $this->token = config('services.pillar_bank.token_secret');
    }

    public function sendTransactionWebhook(Transaction $data): int
    {
        $response = $this->apiCall(
            method: 'post',
            path: 'webhook/transactions',
            data: [
                'card_number' => $data->card_number,
                'amount' => $data->amount,
                'type' => $data->type->value,
                'name' => $data->name,
            ],
        );

        return $response;
    }

    protected function apiCall(string $method, string $path, array $data = []): int
    {
        $request = $this
            ->httpRequestService
            ->set('http_errors', false)
            ->send(
                method: $method,
                url: "{$this->url}/{$path}",
                data: $data,
                headers: $this->prepareHeaders(),
            );

        $response = $request->getResponse();

        if ($response->getStatusCode() > Response::HTTP_BAD_REQUEST) {
            throw new ExternalApiHttpException(
                serviceName: ApiServiceEnum::PillarBank,
                responseCode: $response->getStatusCode(),
                responseData: json_decode($response->getBody(), true),
            );
        }

        return $response->getStatusCode();
    }

    protected function prepareHeaders(array $additionalHeaders = []): array
    {
        return array_merge([
            'authorization' => $this->token,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ], $additionalHeaders);
    }
}
