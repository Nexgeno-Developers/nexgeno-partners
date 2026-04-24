<?php

return [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'encryption' => 'tls',
    'username' => 'webdeveloper@nexgeno.in',
    'password' => 'your-app-password',
    'from_email' => 'webdeveloper@nexgeno.in',
    'from_name' => 'Nexgeno Partners Website',
    'to' => [
        [
            'email' => 'mehtab.makent@gmail.com',
            'name' => 'Mehtab',
        ],
        [
            'email' => 'ansarimehtab645@gmail.com',
            'name' => 'Ansari Mehtab',
        ],
    ],
    'to_email' => 'mehtab.makent@gmail.com',
    'to_name' => 'Mehtab',
    'timeout' => 20,
    'verify_peer' => true,
    'allow_self_signed' => false,
];
