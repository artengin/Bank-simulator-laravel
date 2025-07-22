<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use RonasIT\Support\Traits\ModelTrait;
use App\Enums\Transactions\TypeEnum;

class Transaction extends Model
{
    use CrudTrait;
    use ModelTrait;

    protected $fillable = [
        'name',
        'card_number',
        'amount',
        'type',
        'initializer_id',
    ];

    protected $hidden = ['pivot'];

    protected $casts = [
        'type' => TypeEnum::class,
    ];
}
