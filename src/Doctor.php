<?php
namespace Doctor;

use Exception;
use ZendDiagnostics\Runner\Runner;

class Doctor
{
    const STATUS_PASS = 'pass';
    const STATUS_WARNING = 'warn';
    const STATUS_FAIL = 'fail';

    const ERROR_MISSING_RELEASE_ID = 'Health releaseId not set';
    const ERROR_MISSING_SERVICE_ID = 'Health serviceId not set';

    /**
     * @var string
     */
    private $serviceId;

    /**
     * @var \ZendDiagnostics\Result\Collection
     */
    private $results;

    /**
     * @var string
     */
    private $releaseId;

    /**
     * @var Runner
     */
    private $runner;

    /**
     * @param Runner $runner
     */
    public function __construct(Runner $runner)
    {
        $this->runner = $runner;
    }

    /**
     * @var array
     */
    public function addChecks($checks)
    {
        $this->runner->addChecks($checks);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function diagnose()
    {
        $this->results = $this->runner->run();

        return [
            'status' => $this->getStatus(),
            'releaseID' => $this->getReleaseId(),
            'serviceID' => $this->getServiceId(),
            'details' => $this->getResultDetails()
        ];
    }

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

    private function getResultDetails()
    {
        $details = [];

        foreach($this->results as $check){

            $detail = $this->getDetail($check);

            $details[] = [$detail->getLabel() => $detail->toArray()];
        }

        return $details;
    }

    private function getDetail($check){

        $result = $this->results[$check];

        return new Detail($result, $check);
    }

    /**
     * @return mixed
     */
    public function getServiceId()
    {
        if(empty($this->serviceId)){
            throw new Exception(static::ERROR_MISSING_SERVICE_ID);
        }

        return $this->serviceId;
    }

    /**
     * @param mixed $serviceId
     */
    public function setServiceId($serviceId): void
    {
        $this->serviceId = $serviceId;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getReleaseId()
    {
        if(empty($this->releaseId)){
            throw new Exception(static::ERROR_MISSING_RELEASE_ID);
        }

        return $this->releaseId;
    }

    /**
     * @param string $releaseId
     */
    public function setReleaseId(string $releaseId)
    {
        $this->releaseId = $releaseId;
    }
}
