<?php

namespace App\Http\Resources;

use RonasIT\Support\Http\BaseResource;

class ClientIdentifiedResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
