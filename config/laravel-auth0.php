<?php

return [

    /*
        |--------------------------------------------------------------------------
        |   Your auth0 domain
        |--------------------------------------------------------------------------
        |   As set in the auth0 administration page
        |
    */
    'domain'        => 'carendar-daw.eu.auth0.com',

    /*
        |--------------------------------------------------------------------------
        |   Your APP id
        |--------------------------------------------------------------------------
        |   As set in the auth0 administration page
        |
    */
    'client_id'     => 'FnCY4ajfPN6rFmUN4dB4GqY8cMuMetMP',

    /*
        |--------------------------------------------------------------------------
        |   Your APP secret
        |--------------------------------------------------------------------------
        |   As set in the auth0 administration page
        |
    */
    'client_secret' => '3gi9Fw68gF2ECKeJN1bY7NXDjSnKMfeCXu5dVK9B--NWSZJxeQJYeFkqbXSuWWH4',

    /*
        |--------------------------------------------------------------------------
        |   The redirect URI
        |--------------------------------------------------------------------------
        |   Should be the same that the one configure in the route to handle the
        |   'Auth0\Login\Auth0Controller@callback'
        |
    */
    'redirect_uri'  => env( 'APP_URL' ).'/auth0/callback',

    /*
        |--------------------------------------------------------------------------
        |   Persistence Configuration
        |--------------------------------------------------------------------------
        |   persist_user            (Boolean) Optional. Indicates if you want to persist the user info, default true
        |   persist_access_token    (Boolean) Optional. Indicates if you want to persist the access token, default false
        |   persist_refresh_token   (Boolean) Optional. Indicates if you want to persist the refresh token, default false
        |   persist_id_token        (Boolean) Optional. Indicates if you want to persist the id token, default false
        |
    */
    'persist_user' => true,
    'persist_access_token' => false,
    'persist_refresh_token' => false,
    'persist_id_token' => false,

    /*
        |--------------------------------------------------------------------------
        |   The authorized token audiences
        |--------------------------------------------------------------------------
        |
    */
    // 'api_identifier'  => '',


    /*
        |--------------------------------------------------------------------------
        |   Auth0 Organizations
        |--------------------------------------------------------------------------
        |   organization (string) Optional. Id of an Organization, if being used. Used when generating log in urls and validating token claims.
    */
    // 'organization'  => '',

    /*
        |--------------------------------------------------------------------------
        |   The secret format
        |--------------------------------------------------------------------------
        |   Used to know if it should decode the secret when using HS256
        |
    */
    'secret_base64_encoded'  => false,

    /*
        |--------------------------------------------------------------------------
        |   Supported algorithms
        |--------------------------------------------------------------------------
        |   Token decoding algorithms supported by your API
        |
    */
    'supported_algs'        => [ 'RS256' ],

    /*
        |--------------------------------------------------------------------------
        |   Guzzle Options
        |--------------------------------------------------------------------------
        |   guzzle_options    (array) optional. Used to specify additional connection options e.g. proxy settings
        |
    */
    // 'guzzle_options' => []
    // config/laravel-auth0.php
    // ...
        'authorized_issuers' => [ 'https://carendar-daw.eu.auth0.com/' ],
        // ...
        'api_identifier' => 'http://localhost/carendar/laravel/Carendar-LARAVEL/public/index.php/api',
        // ...
        'supported_algs' => [ 'RS256' ],
        // ...
   
];
