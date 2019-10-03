<?php

namespace RedMarker\Doctor\Checks;

use ZendDiagnostics\Result\ResultInterface;

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
     * @return string
     */
    public function getTime();
}