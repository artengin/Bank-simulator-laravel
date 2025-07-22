<?php

use App\Enums\Clients\StatusEnum;

return [
    'authorization' => [
        'kyc' => env('KYC_SECRET_KEY'),
    ],

    'ssn_status' => [
        '111-11-1111' => StatusEnum::Reject,
    ],
    
    'transaction_names' => [
        'Amazon',
        'Walmart',
        'Best Buy',
        'Apple Store',
        'Google Play',
        'Starbucks',
        'Netflix',
        'Spotify',
        'Uber Eats',
    ],    
];
