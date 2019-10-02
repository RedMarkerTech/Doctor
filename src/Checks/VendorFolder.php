<?php
namespace App\Diagnostics\Checks;

use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Success;

/**
 * Class VendorFolder
 * @package App\Diagnostics\Checks
 */
class VendorFolder extends BaseCheck implements CheckInterface
{
    public $componentType = BaseCheck::TYPE_SYSTEM;

    /**
     * @var string
     */
    protected $label = 'application:vendorFolder';

    /**
     * @var
     */
    private $vendorDirectory;

    /**
     * VendorFolder constructor.
     * @param $vendorDirectory
     */
    public function __construct($vendorDirectory)
    {
        $this->vendorDirectory = $vendorDirectory;

        parent::__construct();
    }

    /**
     * @return Failure|\ZendDiagnostics\Result\ResultInterface|Success
     */
    public function check()
    {
        if (is_dir($this->vendorDirectory)) {
            return new Success();
        }

        return new Failure(null, 'Not Found');
    }
}

