<?php

namespace App\Diagnostics\Checks;

use ZendDiagnostics\Result\Success;
use ZendDiagnostics\Result\Failure;
use Exception;
use Socket\Raw\Factory;
use Xenolope\Quahog\Client;

/**
 * Class Gearman
 * @package App\Diagnostics\Checks
 */
class Gearman extends BaseCheck implements CheckInterface
{
    public $componentType = BaseCheck::TYPE_COMPONENT;

    /**
     * @var string
     */
    protected $label = 'queue:connection';

    /**
     * @var
     */
    private $config;

    /**
     * @var string
     */
    public $componentId = 'gearman';

    /**
     * Gearman constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;

        parent::__construct();
    }

    /**
     * @return Failure|\ZendDiagnostics\Result\ResultInterface|Success
     */
    public function check()
    {
        try{
            $socket = (new Factory())->createClient($this->config);

            new Client($socket, 30, PHP_NORMAL_READ);
        } catch (Exception $e){
            return new Failure(null, $e->getMessage());
        }

        return new Success();
    }
}
