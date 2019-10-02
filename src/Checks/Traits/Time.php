<?php

namespace Doctor\Checks\Traits;

Trait Time
{
    public $time;
    public $componentId;
    public $componentType;
    public $output;
    public $metricValue;
    public $metricUnit;

    public function setTime(string $time = null)
    {
        $this->time = $time ?? date('Y-m-d H:i:s', time());
    }

    public function getTime()
    {
        return $this->time;
    }
}
