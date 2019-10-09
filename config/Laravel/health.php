<?php

/**
 * This is an example health configuration.
 * This config well need to be added to your config directory
 * Proper `.env` values will need to be set
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Service Id
    |--------------------------------------------------------------------------
    |
    | Here you may specify the service_id that should be used
    | by the health check. The service_id should be the containers id.
    |
    */
    'service_id' => env('CONTAINER_ID', 'container-id not found'),

    /*
    |--------------------------------------------------------------------------
    | Release Id
    |--------------------------------------------------------------------------
    |
    | Here you may specify the release_id that should be used
    | by the health check. The release_id should be the current git hash.
    |
    */
    'release_id' => env('RELEASE_ID', 'release-id not found'),

    /*
    |--------------------------------------------------------------------------
    | Vendor Folder Location
    |--------------------------------------------------------------------------
    |
    | Here you may specify the location of that vendor folder that.
    | This location is only used by the VendorFolder Check.
    |
    */
    'vendor_folder' => env('APP_ROOT') . '/vendor',

    /*
    |--------------------------------------------------------------------------
    | .Env File Location
    |--------------------------------------------------------------------------
    |
    | Here you may specify the location of the .env file.
    | This location is used by the EnvFile Check.
    |
    */
    'env_file' => env('APP_ROOT') . '/.env',

    /*
    |--------------------------------------------------------------------------
    | HttpResponse Check configurations
    |--------------------------------------------------------------------------
    |
    | 'service_name' => [
    |       'endpoint' => 'http://redmarker.ai',
    |       'jwt' => $token,
    |       'see_in_response' => [
    |           'success',
    |           'created_at'
    |       ]
    |   ],
    */
    'services' => [
        'component_name' => [
            'endpoint' => env('API_URL'),
            'jwt' => env('API_JWT'),
            'see_in_response' => [
                'success'
            ]
        ],
    ]
];
