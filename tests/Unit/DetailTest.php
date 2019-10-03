<?php
namespace RedMarker\Tests\Unit;

use RedMarker\Tests\BaseTest;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Success;
use RedMarker\Doctor\Checks;
use RedMarker\Doctor\Detail;
use RedMarker\Doctor\Doctor;

class DetailTest extends BaseTest
{
    public function testToArrayWithSuccessResult()
    {
        $check = new Checks\VendorFolder('');

        $detail = new Detail(new Success(), $check);
        $result = $detail->toArray();

        $this->assertEquals($result['componentType'], $check->componentType);
        $this->assertEquals($result['time'], $check->time);
        $this->assertEquals($result['status'], Doctor::STATUS_PASS);
    }

    public function testToArrayReturnsMetrics()
    {
        $check = new Checks\VendorFolder('');
        $unit = 'unit';
        $check->metricUnit = $unit;

        $value = 'value';
        $check->metricValue = $value;

        $detail = new Detail(new Success(), $check);
        $result = $detail->toArray();

        $this->assertEquals($result['metricUnit'], $unit);
        $this->assertEquals($result['metricValue'], $value);
    }

    public function testToArrayWithFailureResult()
    {
        $check = new Checks\VendorFolder('');

        $output = 'output';
        $detail = new Detail(new Failure(null, $output), $check);
        $result = $detail->toArray();

        $this->assertEquals($result['componentType'], $check->componentType);
        $this->assertEquals($result['time'], $check->time);
        $this->assertEquals($result['status'], Doctor::STATUS_FAIL);
        $this->assertEquals($result['output'], $output);
    }

    public function testLabel()
    {
        $check = new Checks\VendorFolder('');

        $detail = new Detail(new Failure(null, 'output'), $check);

        $this->assertEquals($detail->label, $check->getLabel());
    }
}