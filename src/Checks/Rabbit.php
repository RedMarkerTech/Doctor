<?php

namespace RedMarker\Doctor\Checks;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Connection\AMQPSSLConnection;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Success;

/**
 * Validate that a RabbitMQ service is running
 */
class Rabbit extends BaseCheck implements CheckInterface
{
    use Traits\Time;

    /**
     * @var string
     */
    protected $label = 'queue:connection';

    protected $config;

    /**
     * @param array $config
     */
    public function __construct($config)
    {

        $this->config = $config;

        $this->componentType = BaseCheck::TYPE_COMPONENT;

        $this->componentId = 'rabbit';

        $this->setTime();

        parent::__construct();
    }

    /**
     * Perform the check
     *
     * @see \ZendDiagnostics\Check\CheckInterface::check()
     * @return Failure|Success
     */
    public function check()
    {
        if (! class_exists('PhpAmqpLib\Connection\AMQPConnection')) {
            return new Failure('PhpAmqpLib is not installed');
        }
        try {
            $isSsl = !empty($this->config['ssl_options']);
            switch ($isSsl)
            {
                case false:
                    $conn = new AMQPConnection(
                        $this->config['host'],
                        $this->config['port'],
                        $this->config['user'],
                        $this->config['password'],
                        $this->config['vhost']
                    );
                    break;
                case true:
                    $this->componentId .= '-ssl';
                    $conn = new AMQPSSLConnection(
                        $this->config['host'],
                        $this->config['port'],
                        $this->config['user'],
                        $this->config['password'],
                        $this->config['vhost'],
                        $this->config['ssl_options']
                    );
                    break;
            }
            $conn->channel();
        } catch (\Exception $e) {
            return new Failure('Could not connect to specified RabbitMQ', $e->getMessage());
        }
        return new Success();
    }

    /**
     * Return a label describing this test instance.
     *
     * @return string
     */
    public function getLabel()
    {
        return 'rabbit-mq';
    }
}
