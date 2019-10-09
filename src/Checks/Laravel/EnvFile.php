<?php
namespace RedMarker\Doctor\Checks\Laravel;

use RedMarker\Doctor\Checks;

/**
 * Class EnvFile
 * @package Doctor\Checks
 */
class EnvFile extends Checks\EnvFile implements Checks\CheckInterface
{
    /**
     * EnvFile constructor.
     */
    public function __construct()
    {
        parent::__construct(config('health.env_file'));

    }
}

