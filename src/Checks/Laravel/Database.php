<?php
namespace Doctor\Checks\Laravel;

use Doctor\Checks\CheckInterface;
use Illuminate\Support\Facades\DB;
use Doctor\Checks;

class Database extends Checks\Database implements CheckInterface
{
    /**
     * @param  string $connection
     */
    public function __construct(string $connection)
    {
        $this->componentId = $connection;

        $config = DB::connection($connection)->getConfig();

        parent::__construct($config['host'], $config['database'], $config['username'], $config['password']);
    }
}
