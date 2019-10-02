# Red Marker Php Health Status

"I need a doctor" - Dr. Dre

Just like Dre, Red Marker also needs a Doctor.

This is a php-based package for performing health status checks that follow the format found  at https://tools.ietf.org/id/draft-inadarei-api-health-check-01.html

## Doctor Usage

Create an instance of a Doctor class using a new Examination(). 
Passing Doctor\Checks\CheckInterface objects to the Doctor will add them to the Doctors examination attribute.


Both the releaseId and serviceId must be set on the Doctor\Doctor() .

The releaseId should be the current git commit hash.

The serviceId should be the containers id.

``` bash
use ZendDiagnostics\Runner\Runner as Examination;

$doctor = new Doctor\Doctor(Examination $examination);
$doctor->setReleaseId($releaseId);
$doctor->setServiceId($serviceId);
```

## Adding Checks to the Doctor

Pass each Check in an array to the Doctor.

``` bash
$doctor->addChecks([ 
    new Doctor\Checks\Database()
]);

return $doctor->diagnose()->toArray();
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

## Output Diagnosis

Generate the public key:

``` bash

```

