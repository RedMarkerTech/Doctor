<?php
namespace Doctor;

use ReflectionClass;
use ZendDiagnostics\Result\ResultInterface;
use Carbon\Carbon;
use ZendDiagnostics;

class Detail
{
    const STATUS_PASS = 'pass';

    const STATUS_WARNING = 'warn';

    const STATUS_FAIL = 'fail';

    const STATUS_UNKNOWN = 'unknown';

    private $label;

    /**
     * @var string
     */
    private $status;

    /**
     * Result constructor.
     * @param ResultInterface $result
     * @param $check
     */
    public function __construct(ResultInterface $result, $check)
    {
        $this->status = $this->getStatus($result);

        $this->output = $result->getData();

        $this->label = $check->getLabel();

        $this->check = $check;
    }

    /**
     * @param $result
     * @return string
     */
    public function getStatus($result)
    {
        switch (get_class($result)) {
            case ZendDiagnostics\Result\Success::class:
                $status = static::STATUS_PASS;
                break;
            case ZendDiagnostics\Result\Failure::class:
                $status = static::STATUS_FAIL;
                $this->output = $result->getData();
                break;
            case ZendDiagnostics\Result\Warning::class:
                $status = static::STATUS_WARNING;
                $this->output = $result->getData();
                break;
            default :
                $status = static::STATUS_UNKNOWN;
        }

        return $status;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];

        if (!empty($this->check->componentId)) {
            $result['componentId'] = $this->check->componentId;
        }

        if (!empty($this->check->componentType)) {
            $result['componentType'] = $this->check->componentType;
        }

        if (!empty($this->check->metricValue)) {
            $result['metricValue'] = $this->check->metricValue;
        }

        if (!empty($this->check->metricUnit)) {
            $result['metricUnit'] = $this->check->metricUnit;
        }

        if (!empty($this->check->time)) {
            $result['time'] = $this->check->time;
        }

        if (!empty($this->output)) {
            $result['output'] = $this->output;
        }

        $result['status'] = $this->status;

        return $result;
    }
}
