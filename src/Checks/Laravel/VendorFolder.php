<?php
namespace RedMarker\Doctor\Checks\Laravel;

use RedMarker\Doctor\Checks;

/**
 * Class VendorFolder
 * @package Doctor\Checks
 */
class VendorFolder extends Checks\VendorFolder implements Checks\CheckInterface
{
    /**
     * VendorFolder constructor.
     */
    public function __construct()
    {
        parent::__construct(config('health.vendor_folder'));
    }
}