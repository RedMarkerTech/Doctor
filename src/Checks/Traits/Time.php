<?php

namespace Doctor\Checks\Traits;

use Carbon\Carbon;

Trait Time
{
    public $time;
    public $componentId;
    public $componentType;
    public $output;
    public $metricValue;
    public $metricUnit;

    public function setTime(Carbon $time = null)
    {
        $this->time = $time ?? Carbon::now();
    }

    public function getTime()
    {
        return $this->time;
    }
}
