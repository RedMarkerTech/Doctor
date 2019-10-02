<?php

namespace Doctor;

use Exception;
use ZendDiagnostics\Runner\Runner as Examination;

/**
 * Class Doctor
 *
 * @package Doctor
 */
class Doctor
{
    const STATUS_PASS = 'pass';
    const STATUS_WARNING = 'warn';
    const STATUS_FAIL = 'fail';
    const STATUS_UNKNOWN = 'unknown';
    const ERROR_MISSING_RELEASE_ID = 'Health releaseId not set';
    const ERROR_MISSING_SERVICE_ID = 'Health serviceId not set';

    /**
     * @var \ZendDiagnostics\Result\Collection
     */
    private $results;

    /**
     * @var Examination
     */
    private $examination;

    /**
     * @var Diagnosis
     */
    public $diagnoses;

    /**
     * @param Examination $examination The checks will be added to this examination
     */
    public function __construct(Examination $examination)
    {
        $this->examination = $examination;

        $this->diagnoses = new Diagnosis();
    }

    /**
     * @param string $serviceId
     */
    public function setServiceId(string $serviceId): void
    {
        $this->diagnoses->serviceId = $serviceId;
    }

    /**
     * @param string $releaseId
     */
    public function setReleaseId(string $releaseId)
    {
        $this->diagnoses->releaseId = $releaseId;
    }

    /**
     * @param array $checks Doctor\Checks\CheckInterface[]
     */
    public function addChecks(array $checks)
    {
        $this->examination->addChecks($checks);
    }

    /**
     * Run the checks on the examination and parse the results into a diagnoses
     *
     * @return Diagnosis
     * @throws Exception
     */
    public function diagnose()
    {
        if(empty($this->diagnoses->releaseId)){
            throw new Exception(static::ERROR_MISSING_RELEASE_ID);
        }

        if(empty($this->diagnoses->serviceId)){
            throw new Exception(static::ERROR_MISSING_SERVICE_ID);
        }

        $this->results = $this->examination->run();

        $this->diagnoses->status = $this->getStatus();

        $this->diagnoses->details = $this->getResultDetails();

        return $this->diagnoses;
    }

    /**
     * Determine the status of the Diagnoses from the warning and failure counts
     *
     * @return string
     */
    private function getStatus()
    {
        if ($this->results->getFailureCount() > 0){
            return static::STATUS_FAIL;
        }

        if ($this->results->getWarningCount() > 0){
            return static::STATUS_WARNING;
        }

        return static::STATUS_PASS;
    }

    /**
     * To access the result for each check we need to pass the CheckInterface object
     * as the look up key into the collection of results.
     *
     * Parse the Checks along with their corresponding Results to construct an array of Details
     */
    private function getResultDetails()
    {
        $details = [];

        foreach($this->results as $check){

            $result = $this->results[$check];

            //Format the result and check into a detail
            $detail = new Detail($result, $check);

            $details[] = [$detail->label => $detail->toArray()];
        }

        return $details;
    }
}
