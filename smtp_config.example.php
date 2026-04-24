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
            'email' => 'tamir@nexgeno.in',
            'name' => 'Tamir',
        ],
        [
            'email' => 'arif@nexgeno.in',
            'name' => 'Arif',
        ],

        [
            'email' => 'sales@nexgeno.in',
            'name' => 'Sales Team',
        ],
    ],
    'timeout' => 20,
    'verify_peer' => true,
    'allow_self_signed' => false,
];
