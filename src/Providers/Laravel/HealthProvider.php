<?php

namespace RedMarker\Doctor\Providers\Laravel\HealthProvider;

use Illuminate\Support\ServiceProvider;
use RedMarker\Doctor\Doctor;
use ZendDiagnostics\Runner\Runner;

class HealthProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Doctor::class, function ($app) {

            $doctor = new Doctor(resolve(Runner::class));
            $doctor->setServiceId(config('health.service_id'));
            $doctor->setReleaseId(config('health.release_id'));

            return $doctor;
        });
    }
}
