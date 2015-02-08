<?php

return array(

    'GitHub' => array(
        'client_id'     => env('OAUTH_GITHUB_CLIENT_ID'),
        'client_secret' => env('OAUTH_GITHUB_CLIENT_SECRET'),
        'callback'         => 'auth/GitHub/callback',
        'scope'         => ['user:email']
    )
);