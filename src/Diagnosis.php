<?php
namespace RedMarker\Doctor;


/**
 * Class Diagnoses
 *
 * Summary of the Checks and Results
 *
 * @package Doctor
 */
class Diagnosis
{
    /**
     * Status of the Diagnoses.
     * Can be one either pass, fail, or warn.
     *
     * @var string
     */
    public $status;

    /**
     * The releaseId should be the current git commit hash
     *
     * @var string
     */
    public $releaseId;

    /**
     * The serviceId should be the container id
     *
     * @var string
     */
    public $serviceId;

    /**
     * Array of the details parse from the Checks and Results
     *
     * @var array Doctor\Checks\CheckInterface[]
     */
    public $details;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'status' => $this->status,
            'releaseID' => $this->releaseId,
            'serviceID' => $this->serviceId,
            'details' => $this->details,
        ];
    }
}