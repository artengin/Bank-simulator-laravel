<?php

namespace App\Services;

use App\Models\Client;
use App\Repositories\ClientRepository;
use RonasIT\Support\Services\EntityService;
use App\Enums\Clients\StatusEnum;

/**
 * @property ClientRepository $repository
 */
class ClientService extends EntityService
{
    public function __construct()
    {
        $this->setRepository(ClientRepository::class);
    }

    public function identifyClient(array $data): Client
    {
        $data['status'] = config('defaults.ssn_status')[$data['ssn']] ?? StatusEnum::Approve;

        $client = $this->firstOrCreate(['phone' => $data['phone']], $data);

        return $client;
    }
}
