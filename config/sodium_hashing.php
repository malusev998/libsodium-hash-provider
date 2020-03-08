<?php

return [
    'argon' => [
        'memory' => env('SODIUM_DEFAULT_MEMORY', intdiv(SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE, 2)),
        'time' => env('SODIUM_DEFAULT_TIME', SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE),
        'check_bcrypt' => env('SODIUM_CHECK_BCRYPT', false)
    ],

    'scrypt' => [
        'memory' => env('SODIUM_SCRYPT_MEMORY', intdiv(SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE, 2)),
        'time' => env('SODIUM_SCRYPT_TIME', SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE),
    ]
];
