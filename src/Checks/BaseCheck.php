<?php
namespace RedMarkerTech\Doctor\Checks;

use RedMarkerTech\Doctor\Checks\Traits\Time;
use ZendDiagnostics\Check\AbstractCheck;

/**
 * Class BaseCheck
 * @package Doctor\Checks
 */
abstract class BaseCheck extends AbstractCheck
{
    use Time;

    const TYPE_COMPONENT = 'component';

    const TYPE_DATASTORE = 'datastore';

    const TYPE_SYSTEM = 'system';

    /**
     * @var string
     */
    public $componentId;

    /**
     * BaseCheck constructor.
     */
    public function __construct()
    {
        $this->setTime();
    }

    /**
     * @param $componentId
     */
    public function setComponentId($componentId)
    {
        $this->componentId = $componentId;
    }
}

