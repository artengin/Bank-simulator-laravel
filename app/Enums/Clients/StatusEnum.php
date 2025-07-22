<?php

namespace App\Enums\Clients;

use RonasIT\Support\Traits\EnumTrait;

enum StatusEnum: string
{
    use EnumTrait;

    case Approve = 'approve';
    case Reject = 'reject';
}
