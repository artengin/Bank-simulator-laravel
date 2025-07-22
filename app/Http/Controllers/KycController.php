<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kyc\KycRequest;
use App\Services\ClientService;
use App\Http\Resources\ClientIdentifiedResource;

class KycController extends Controller
{
    public function __construct(
        protected ClientService $clientService
    ) {
    }

    public function identifyClient(KycRequest $request): ClientIdentifiedResource
    {
        $data = $request->validated();

        $client = $this->clientService->identifyClient($data);

        return ClientIdentifiedResource::make($client);
    }
}
