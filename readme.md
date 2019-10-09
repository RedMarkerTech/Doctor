# Red Marker Php Health Status

This is a php-based package for performing health status checks that follow the format found  at https://tools.ietf.org/id/draft-inadarei-api-health-check-01.html

"I need a doctor" - Dr. Dre

Just like Dre, you might need a Doctor too.

## Installation

``` bash
composer require redmarker/doctor
```

## Doctor Usage

Create an instance of a Doctor class using a new Examination(). 

Passing RedMarker\Doctor\Checks\CheckInterface objects to the Doctor will add them to the Doctors examination attribute.

Both the releaseId and serviceId must be set on the RedMarker\Doctor\Doctor() .

The releaseId should be the current git commit hash.

The serviceId should be the containers id.

``` bash
use ZendDiagnostics\Runner\Runner as Examination;

$doctor = new RedMarker\Doctor\Doctor(Examination $examination);
$doctor->setReleaseId($releaseId);
$doctor->setServiceId($serviceId);
```

## Adding Checks to the Doctor

Pass each Check in an array to the Doctor.

``` bash
$doctor->addChecks([ 
    new Doctor\Checks\Database()
]);

return $doctor->diagnose();
```

### Output:
``` bash
{
    "status": "pass",
    "releaseID": "5113e3d0ad8fe3f1ac8393e17432353b194a060f",
    "serviceID": "34ebdffa9cba",
    "details": [
        {
            "database:connection": {
                "componentId": "api",
                "componentType": "datastore",
                "time": "2019-10-01T06:23:35.817073Z",
                "status": "pass"
            }
        }
    ]
}
```
## Laravel Usage

For Laravel usage the below service provider should be registered in config/app.php

```
RedMarker\Doctor\Providers\Laravel\HealthProvider::class
```

Setup configuration for Laravel Checks:

```php
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
```