<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Agent
    |--------------------------------------------------------------------------
    |
    | Application identification:
    | https://fakturoid.docs.apiary.io/#introduction/identifikace-vasi-aplikace
    |
    | User-agent header is required, otherwise API returns 400 Bad Request
    | response.
    |
    | If 'include_email' set to true, email from Settings section will be
    | included.
    |
    */
    'user_agent' => [
        'name' => 'Fakturoid plugin for OctoberCMS',
        'include_email' => true,
    ],
];
