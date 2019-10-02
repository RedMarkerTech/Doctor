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
    new Doctor\Checks\Database(),
    new Doctor\Checks\EnvFile()
]);
```

## Output Diagnosis

Generate the public key:

``` bash
Doctor\Diagnoses $diagnoses = $doctor->diagnose();
```

