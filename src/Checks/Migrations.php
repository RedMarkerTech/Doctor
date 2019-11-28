<?php
namespace RedMarker\Doctor\Checks;

use PDO;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Success;
use ZendDiagnostics\Result\Warning;
use RedMarker\Doctor\Checks;

/**
 * Validate Migrations are up to date
 */
class Migrations extends Checks\BaseCheck implements Checks\CheckInterface
{
    public $componentType = BaseCheck::TYPE_DATASTORE;

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
        $files = $this->getMigrationFiles();

        if(!$files){

            return new Warning(null, 'No migration files found.');
        }

        $dbMigrationsCount = $this->getMatchingMigrationRecordsCount($files);

        $fileCount = (string) count($files);

        if($fileCount === $dbMigrationsCount){

            return new Success();
        }

        return new Failure(null, [
            'file count' => $fileCount,
            'db record count' => $dbMigrationsCount
        ]);
    }

    /**
     * Gets an array of the migration file names
     * the .php extension is removed from the file name
     *
     * @return array
     */
    private function getMigrationFiles()
    {
        $migrations = [];

        $migrationFiles = scandir($this->migrationDirectory, SCANDIR_SORT_DESCENDING);

        if(empty($migrationFiles)){
            return false;
        }

        foreach($migrationFiles as $file)
        {
            $extension = substr($file, -4);

            if ($extension === '.php'){
                $migrations[] = str_replace('.php', '', $file);
            }
        }

        return $migrations;
    }

    /**
     * @return string
     */
    private function getMatchingMigrationRecordsCount($files = [])
    {
        $db = new PDO($this->dsn, $this->username, $this->password, $this->options);

        $in  = str_repeat('?,', count($files) - 1) . '?';

        $query = "SELECT count(*) as count FROM migrations where migration in ($in)";

        $statement = $db->prepare($query);

        $statement->execute($files);

        $record = $statement->fetch();

        return $record['count'];
    }
}