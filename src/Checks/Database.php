<?php
namespace RedMarker\Doctor\Checks;

use ZendDiagnostics\Check\PDOCheck;

/**
 * Class Database
 * @package Doctor\Checks
 */
class Database extends PDOCheck implements CheckInterface
{
    use Traits\Time;

    public $componentType = BaseCheck::TYPE_DATASTORE;

    /**
     * @param string $host
     * @param string $database
     * @param string $username
     * @param string $password
     * @param int $timeout
     *
     * @return self
     */
    public function __construct($host, $database, $username, $password, $timeout = 1)
    {
        $dsn = 'mysql:host=' . $host . ';dbname=' . $database;

        parent::__construct($dsn, $username, $password, $timeout);

        $this->setTime();
    }

    /**
     * The parent PDOCheck overloads it's parents function
     * We need to overload it again here to get the right format
     *
     * @return string
     */
    public function getLabel()
    {
        return 'database:connection';
    }
}
