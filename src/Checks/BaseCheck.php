<?php
namespace App\Diagnostics\Checks;

use App\Diagnostics\Checks\Traits\Time;
use ZendDiagnostics\Check\AbstractCheck;

/**
 * Class BaseCheck
 * @package App\Diagnostics\Checks
 */
abstract class BaseCheck extends AbstractCheck
{
    use Time;

    const TYPE_COMPONENT = 'component';

    const TYPE_DATASTORE = 'datastore';

    const TYPE_SYSTEM = 'system';

    /**
     * @var
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

