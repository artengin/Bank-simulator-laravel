<?php

namespace App\Repositories;

use App\Models\Client;
use RonasIT\Support\Repositories\BaseRepository;

/**
 * @property Client $model
 */
class ClientRepository extends BaseRepository
{
    public function __construct()
    {
        $this->setModel(Client::class);
    }
}
