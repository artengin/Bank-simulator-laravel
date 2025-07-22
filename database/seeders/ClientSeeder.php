<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\ClientFactory;

class ClientSeeder extends Seeder
{
    public function run()
    {
        ClientFactory::new()->create();
    }
}
