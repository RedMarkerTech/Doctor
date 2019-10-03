<?php
namespace RedMarkerTech\Doctor\Checks;

use PDO;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Success;
use ZendDiagnostics\Result\Warning;
use Doctor\Checks;

/**
 * Validate Migrations are up to date
 */
class Migrations extends Checks\BaseCheck implements Checks\CheckInterface
{
    public $componentType = BaseCheck::TYPE_DATASTORE;

    const QUERY = "SELECT migration FROM migrations order by id desc LIMIT 1";

    /**
     * @var string
     */
    protected $label = 'database:migrations';

    /**
     * @var string
     */
    private $migrationDirectory;

    /**
     * @param string $host
     * @param string $database
     * @param string $username
     * @param string $password
     * @param string $migrationDirectory
     */
    public function __construct($host, $database, $username, $password, $migrationDirectory)
    {
        $this->dsn = 'mysql:host=' . $host . ';dbname=' . $database;

        $this->username = $username;

        $this->password = $password;

        $this->options = [];

        $this->migrationDirectory = $migrationDirectory;

        parent::__construct();
    }

    /**
     * @return Failure|\ZendDiagnostics\Result\ResultInterface|Success|Warning
     */
    public function check()
    {
        $latestMigrationFile = $this->getLatestMigrationFile();

        if(!$latestMigrationFile){

            return new Warning(null, 'No migration files found.');
        }

        $latestMigrationDbRecord = $this->getLatestMigrationDbRecord();

        if($latestMigrationDbRecord === $latestMigrationFile){

            return new Success();
        }

        return new Failure(null, [
            'file' => $latestMigrationFile,
            'record' => $latestMigrationDbRecord
        ]);
    }

    /**
     * @return bool|mixed
     */
    private function getLatestMigrationFile()
    {
        $migrationFiles = scandir($this->migrationDirectory, SCANDIR_SORT_DESCENDING);

        if(empty($migrationFiles)){
            return false;
        }

        return str_replace('.php', '', $migrationFiles[0]);
    }

    /**
     * @return string
     */
    private function getLatestMigrationDbRecord()
    {
        $db = new PDO($this->dsn, $this->username, $this->password, $this->options);

        $statement = $db->prepare(static::QUERY);

        $statement->execute();

        $record = $statement->fetch();

        return $record['migration'];
    }
}

