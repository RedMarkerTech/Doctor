<?php

namespace RedMarker\Doctor\Checks\Laravel;

use RedMarker\Doctor\Checks;

/**
 * Validate that a RabbitMQ service is running
 */
class Rabbit extends Checks\Rabbit implements Checks\CheckInterface
{
    /**
     * @param string $connection
     */
    public function __construct($connection)
    {
        $config = config('queue.connections.' . $connection);

        parent::__construct($config);

        $this->componentId .= '-'.$connection;
    }
}
