<?php

declare(strict_types=1);

use App\Config\Env;

return [
    'http' => [
        'address' => Env::str('SEM_HTTP_ADDRESS', '0.0.0.0'),
        'port' => Env::int('SEM_HTTP_PORT', 8080),
        'workers' => Env::int('SEM_HTTP_WORKERS', 4)
    ]
];
