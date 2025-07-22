<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\TransactionFactory;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        TransactionFactory::new()->create();
    }
}
