<?php
namespace RedMarker\Doctor\Checks\Laravel;

use RedMarker\Doctor\Checks;

/**
 * Class Service
 * @package Doctor\Checks
 */
class HttpResponse extends Checks\HttpResponse implements Checks\CheckInterface
{
    /**
     * Service constructor.
     *
     * @param string $componentId
     */
    public function __construct(string $componentId)
    {
        if ($jwt = config('health.services.' . $componentId . '.jwt')) {
            $this->setJwt($jwt);
        }

        if ($response = config('health.services.' . $componentId . '.see_in_response')) {
            $this->setSeeInResponse($response);
        }

        parent::__construct($componentId, config('health.services.' . $componentId . '.endpoint'));
    }
}