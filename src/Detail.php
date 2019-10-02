<?php
namespace Doctor;

use Carbon\Carbon;
use Doctor\Checks\CheckInterface;
use ZendDiagnostics\Result\ResultInterface;
use ZendDiagnostics;

/**
 * Class Detail
 * @package Doctor
 */
class Detail
{
    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $componentId;

    /**
     * @var string
     */
    public $componentType;

    /**
     * @var string
     */
    public $metricValue;

    /**
     * @var string
     */
    public $metricUnit;

    /**
     * @var string
     */
    public $output;

    /**
     * @var Carbon
     */
    public $time;

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'status',
        'componentId',
        'componentType',
        'metricValue',
        'metricUnit',
        'output',
        'time',
    ];

    /**
     * Result constructor.
     * @param ResultInterface $result
     * @param $check
     */
    public function __construct(ResultInterface $result, CheckInterface $check)
    {
        $this->status = $this->getStatus($result);
        $this->output = $result->getData();
        $this->label = $check->getLabel();
        $this->componentId = $check->componentId;
        $this->componentType = $check->componentType;
        $this->metricValue = $check->metricValue;
        $this->metricUnit = $check->metricUnit;
        $this->time = $check->time;
    }

    /**
     * @param $result
     * @return string
     */
    public function getStatus($result)
    {
        switch (get_class($result)) {
            case ZendDiagnostics\Result\Success::class:
                $status = Doctor::STATUS_PASS;
                break;
            case ZendDiagnostics\Result\Failure::class:
                $status = Doctor::STATUS_FAIL;
                $this->output = $result->getData();
                break;
            case ZendDiagnostics\Result\Warning::class:
                $status = Doctor::STATUS_WARNING;
                $this->output = $result->getData();
                break;
            default :
                $status = Doctor::STATUS_UNKNOWN;
        }

        return $status;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];

        foreach($this->visible as $attribute){
            if (!empty($this->$attribute)) {
                $result[$attribute] = $this->$attribute;
            }
        }

        return $result;
    }
}
