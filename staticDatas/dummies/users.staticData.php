<?php

return [
    [
        'user_id'     => '11111111-1111-1111-1111-111111111111',
        'first_name'  => 'Juan',
        'middle_name' => 'R.',
        'last_name'   => 'Dela Cruz',
        'username'    => 'juandelacruz',
        'password'    => 'zombieSafe99', // will be hashed by the seeder
        'role'    => 'user',
    ],
    [
        'user_id'     => '22222222-2222-2222-2222-222222222222',
        'first_name'  => 'Admin',
        'middle_name' => '',
        'last_name'   => 'User',
        'username'    => 'admin',
        'password'    => 'admin123',
        'role'    => 'admin',
    ],
];