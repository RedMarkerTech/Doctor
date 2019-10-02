<?php
namespace Doctor\Checks\Laravel;

use Exception;
use Doctor\Checks\CheckInterface;
use ZendDiagnostics\Result\Success;
use ZendDiagnostics\Result\Failure;
use Illuminate\Support\Facades\Storage;
use Doctor\Checks\BaseCheck;

/**
 * Class AwsBucket
 * @package Doctor\Checks\Laravel
 */
class AwsBucket extends BaseCheck implements CheckInterface
{
    public $componentType = BaseCheck::TYPE_DATASTORE;

    /**
     * @var string
     */
    private $bucket;

    /**
     * @var string
     */
    protected $label = 'aws-bucket:connection';

    /**
     * @param  string $bucket
     */
    public function __construct($bucket)
    {
        $this->bucket = $bucket;

        $this->componentId = $bucket;

        parent::__construct();
    }

    /**
     * @return Failure|\ZendDiagnostics\Result\ResultInterface|Success
     */
    public function check()
    {
        try {
            Storage::disk($this->bucket)->exists('file.jpg');
        } catch (Exception $e) {

            return new Failure(null, $e->getMessage());
        }

        return new Success();
    }
}
