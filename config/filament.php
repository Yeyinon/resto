<?php

return [
    'panel' => [
        'path' => 'admin',
        'middleware' => ['web', 'auth'],
    ],
    'auth' => [
        'guard' => 'web',
    ],
    // Autres configurations spécifiques à ton projet
];
