<?php
namespace RedMarker\Tests\Unit;

use RedMarker\Tests\BaseTest;
use ZendDiagnostics\Runner\Runner;
use RedMarker\Doctor\Doctor;
use Exception;
use RedMarker\Doctor\Checks;


class DoctorTest extends BaseTest
{
    private $runner;
    private $doctor;
    private $releaseId;
    private $serviceId;

    public function setUp()
    {
        $this->runner = new Runner();
        $this->doctor = new Doctor($this->runner);

        $this->releaseId = 'release-id';
        $this->serviceId = 'service-id';

        parent::setUp();
    }

    public function testDiagnoseThrowsExceptionOnMissingReleaseId()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(Doctor::ERROR_MISSING_RELEASE_ID);

        $this->doctor->diagnose();
    }

    public function testDiagnoseThrowsExceptionOnMissingServiceId()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(Doctor::ERROR_MISSING_SERVICE_ID);

        $this->doctor->setReleaseId('id');
        $this->doctor->diagnose();
    }

    public function testDiagnose()
    {
        $this->doctor->setReleaseId($this->releaseId);
        $this->doctor->setServiceId($this->serviceId);

        $health = $this->doctor->diagnose()->toArray();

        $this->assertEquals($health['status'], Doctor::STATUS_PASS);
        $this->assertEquals($health['releaseID'], $this->releaseId);
        $this->assertEquals($health['serviceID'], $this->serviceId);
        $this->assertEmpty($health['details']);
    }

    public function testDiagnoseReturnsDetails()
    {
        $this->doctor->setReleaseId($this->releaseId);
        $this->doctor->setServiceId($this->serviceId);

        $check = new Checks\VendorFolder('');
        $this->doctor->addChecks([$check]);

        $health = $this->doctor->diagnose()->toArray();

        $this->assertEquals($health['status'], Doctor::STATUS_FAIL);

        $detail = $health['details'][0];
        $this->assertArrayHasKey($check->getLabel(), $detail);
        $detailData = $detail[$check->getLabel()];
        $this->assertEquals('fail', $detailData['status']);
        $this->assertEquals($check->getTime(), $detailData['time']);
    }
}