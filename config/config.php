<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'api_url' => env('EZEEP_API_URL', "https://accounts.ezeep.com/api/"),
    'client_id' => env('EZEEP_CLIENT_ID'),
    'client_secret' => env('EZEEP_CLIENT_SECRET'),
    'client_username' => env('EZEEP_CLIENT_USERNAME'),
    'client_password' => env('EZEEP_CLIENT_PASSWORD'),
];
