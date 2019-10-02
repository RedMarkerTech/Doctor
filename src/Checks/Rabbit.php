<?php

namespace App\Diagnostics\Checks;

use ZendDiagnostics\Check\RabbitMQ;

/**
 * Validate that a RabbitMQ service is running
 */
class Rabbit extends RabbitMQ implements CheckInterface
{
    use Traits\Time;

    public $componentType = BaseCheck::TYPE_COMPONENT;

    /**
     * @var string
     */
    protected $label = 'queue:connection';

    /**
     * @var string
     */
    public $componentId = 'rabbit';

    /**
     * @param array $config
     */
    public function __construct($config)
    {
        parent::__construct($config['host'], $config['port'], $config['user'], $config['password'], $config['vhost']);

        $this->setTime();
    }
}
