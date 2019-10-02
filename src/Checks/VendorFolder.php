<?php
namespace Doctor\Checks;

use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Success;

/**
 * Class VendorFolder
 * @package Doctor\Checks
 */
class VendorFolder extends BaseCheck implements CheckInterface
{
    /**
     * @var string
     */
    public $componentType = BaseCheck::TYPE_SYSTEM;

    /**
     * @var string
     */
    protected $label = 'application:vendorFolder';

    /**
     * @var string The location of the expected vendor folder
     */
    private $vendorDirectory;

    /**
     * VendorFolder constructor.
     * @param string $vendorDirectory
     */
    public function __construct(string $vendorDirectory)
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

