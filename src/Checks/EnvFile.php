<?php
namespace RedMarker\Doctor\Checks;

use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Success;

/**
 * Class EnvFile
 * @package Doctor\Checks
 */
class EnvFile extends BaseCheck implements CheckInterface
{
    public $componentType = BaseCheck::TYPE_SYSTEM;

    /**
     * @var string
     */
    protected $label = 'application:envFile';

    /**
     * @var
     */
    private $file;

    /**
     * EnvFile constructor.
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;

        parent::__construct();
    }

    /**
     * @return Failure|\ZendDiagnostics\Result\ResultInterface|Success
     */
    public function check()
    {
        if (file_exists ($this->file)) {
            return new Success();
        }

        return new Failure(null, '.env file not found');
    }
}

