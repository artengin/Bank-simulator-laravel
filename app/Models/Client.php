<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use RonasIT\Support\Traits\ModelTrait;
use App\Enums\Clients\StatusEnum;

class Client extends Model
{
    use CrudTrait;
    use ModelTrait;

    protected $fillable = [
        'first_name',
        'last_name',
        'ssn',
        'phone',
        'email',
        'status',
    ];

    protected $hidden = ['pivot'];

    protected function casts(): array
    {
        return [
            'status' => StatusEnum::class,
        ];
    }
}
