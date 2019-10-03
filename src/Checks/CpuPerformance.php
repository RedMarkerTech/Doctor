<?php
namespace RedMarker\Doctor\Checks;

use ZendDiagnostics\Check\CpuPerformance as CpuPerformanceAlias;
use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Success;
use ZendDiagnostics\Result\Warning;

/**
 * Class CpuPerformance
 * @package Doctor\Checks
 */
class CpuPerformance extends CpuPerformanceAlias implements CheckInterface
{
    use Traits\Time;

    public $componentType = BaseCheck::TYPE_SYSTEM;

    /**
     * @var string
     */
    protected $label = 'cpu:performance';

    /**
     * The baseline performance for PI calculation, in seconds
     *
     * @var float
     */
    protected $baseline = 1.0;

    /**
     * Decimal precision of PI calculation
     *
     * @var int
     */
    protected $precision = 1000;

    /**
     * Minimum performance for the check to result in a success
     *
     * @var float
     */
    protected $minPerformance = 1;

    /**
     * Expected result from calculating a PI of given decimal $precision
     *
     * @var string
     */
    protected $expectedResult = '3.1415926535897932384626433832795028841971693993751058209749445923078164062862089986280348253421170679821480865132823066470938446095505822317253594081284811174502841027019385211055596446229489549303819644288109756659334461284756482337867831652712019091456485669234603486104543266482133936072602491412737245870066063155881748815209209628292540917153643678925903600113305305488204665213841469519415116094330572703657595919530921861173819326117931051185480744623799627495673518857527248912279381830119491298336733624406566430860213949463952247371907021798609437027705392171762931767523846748184676694051320005681271452635608277857713427577896091736371787214684409012249534301465495853710507922796892589235420199561121290219608640344181598136297747713099605187072113499999983729780499510597317328160963185950244594553469083026425223082533446850352619311881710100031378387528865875332083814206171776691473035982534904287554687311595628638823537875937519577818577805321712268066130019278766111959092164201989';

    /**
     * CpuPerformance constructor.
     * @param float $minPerformance
     */
    public function __construct($minPerformance = 0.5)
    {
        parent::__construct($minPerformance);

        $this->setTime();
    }

    /**
     * Run CPU benchmark and return a Success if the result is higher than minimum performance,
     * Failure if below and a warning if there was a problem with calculating the value of PI.
     *
     * @return Failure|Success|Warning
     */
    public function check()
    {
        // Check if bcmath extension is present
        if (! extension_loaded('bcmath')) {
            return new Warning('Check\CpuPerformance requires BCMath extension to be loaded.');
        }

        $timeStart = microtime(true);
        $result = CpuPerformanceAlias::calcPi(1000);
        $duration = microtime(true) - $timeStart;
        $performance = $duration / $this->baseline;

        $this->metricValue = round($performance, 200);

        $this->metricUnit = 'ms';

        if ($result != $this->expectedResult) {

            return new Warning(null, 'PI calculation failed. This might mean CPU or RAM failure');
        } elseif ($performance > $this->minPerformance) {
            return new Success();
        } else {
            return new Failure(null, [
                'minimum' => $this->minPerformance
            ]);
        }
    }
}

