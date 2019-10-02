<?php
namespace Doctor\Tests\Unit;

use Doctor\Tests\BaseTest;
use ReflectionClass;
use ZendDiagnostics\Runner\Runner;
use Doctor\Doctor;
use Exception;
use Mockery;


class DoctorTest extends BaseTest
{
    private $runner;
    private $doctor;

    public function setUp()
    {
        $this->runner = new Runner();
        $this->doctor = new Doctor($this->runner);

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
        $releaseId = 'release-id';
        $serviceId = 'service-id';

        $this->doctor->setReleaseId($releaseId);
        $this->doctor->setServiceId($serviceId);
        $health = $this->doctor->diagnose();

        $this->assertEquals($health['status'], Doctor::STATUS_PASS);
        $this->assertEquals($health['releaseID'], $releaseId);
        $this->assertEquals($health['serviceID'], $serviceId);
        $this->assertEmpty($health['details']);
    }

    public function testDiagnoseReturnsDetails()
    {
        $doctor = Mockery::mock(Doctor::class, [$this->runner])->makePartial();

        $class = new ReflectionClass ($doctor);
        $method = $class->getMethod ('getDetail');
        $method->setAccessible(true);

        $doctor->shouldReceive('getDetail')->andReturn([]);

    }

}