<?php
namespace RedMarker\Doctor\Checks\Laravel;

use Illuminate\Support\Facades\DB;
use RedMarker\Doctor\Checks;

/**
 * Class Migrations
 * @package Doctor\Checks\Laravel
 */
class Migrations extends Checks\Migrations implements Checks\CheckInterface
{
    /**
     * @var string
     */
    protected $label = 'database:migrations';

    /**
     * @var string
     */
    private $migrationDirectory;

    public function __construct()
    {
        $this->migrationDirectory = env('APP_ROOT') . '/database/migrations/';

        $this->componentId = config('database.default');

        $config = DB::getConfig();

        $migrationDirectory = env('APP_ROOT') . '/database/migrations/';

        parent::__construct($config['host'], $config['database'], $config['username'], $config['password'], $migrationDirectory);
    }
}

