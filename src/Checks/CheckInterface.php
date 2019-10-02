<?php

namespace App\Diagnostics\Checks;

use ZendDiagnostics\Result\ResultInterface;
use Carbon\Carbon;

interface CheckInterface
{
    /**
     * Perform the actual check and return a ResultInterface
     *
     * @return ResultInterface
     */
    public function check();

    /**
     * Return a label describing this test instance.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Return the timestamp describing the instance.
     *
     * @return Carbon
     */
    public function getTime();
}
