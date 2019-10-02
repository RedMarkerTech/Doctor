<?php
namespace App\Diagnostics\Checks;

use ZendDiagnostics\Result\Failure;
use ZendDiagnostics\Result\Success;
use GuzzleHttp\Client;
use Exception;

/**
 * Class Service
 * @package App\Diagnostics\Checks
 */
class Service extends BaseCheck implements CheckInterface
{
    public $componentType = BaseCheck::TYPE_COMPONENT;

    protected $label = 'service:connection';

    /**
     * @var string
     */
    private $service;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $expectedResponses = [];

    /**
     * @var array
     */
    private $seeInResponse = [];

    /**
     * @var array
     */
    private $headers;

    /**
     * Service constructor.
     *
     * @param string $componentId
     * @param string $service
     */
    public function __construct(string $componentId, string $service)
    {
        $this->componentId = $componentId;

        $this->service = $service;

        $this->client = new Client();

        parent::__construct();
    }

    /**
     * @param $jwt
     */
    public function setJwt($jwt)
    {
        $this->headers = [
            'headers' => [
                'Authorization'     => "Bearer " . $jwt
            ]
        ];
    }

    /**
     * @param $response
     */
    public function setExpectedResponses($response)
    {
        $this->expectedResponses = $response;
    }

    /**
     * @return Failure|\ZendDiagnostics\Result\ResultInterface|Success
     */
    public function check()
    {
        try {
            $response = $this->client->get($this->service, $this->headers);
        } catch ( Exception $e) {
            return new Failure(null, $e->getMessage());
        }

        $statusCode = $response->getStatusCode();


        if ($statusCode !==  200) {

            return Failure(null, $statusCode);
        }


        try {
            $this->checkExpectedResponses($response);
        } catch (Exception $e) {
            return new Failure(null, $e->getMessage());
        }

        return new Success();
    }

    /**
     * @param $response
     * @throws Exception
     */
    private function checkExpectedResponses($response)
    {
        $response = $response->getBody()->getContents();

        foreach($this->seeInResponse as $needle)
        {
            if (strpos($response, $needle) !== false) {
                continue;
            }

            throw new Exception($needle . ' not found in response');
        }

        $response = json_decode($response);

        foreach($this->expectedResponses as $key => $value){

            if(is_null($value)) {
                throw new Exception("Expected value can't be null");
            }

            if(!isset($response->$key)) {
                throw new Exception($key . ' not found');
            }

            if($response->$key !== $value) {
                throw new Exception($response->$key . ' does not equal ' . $value);
            }
        }
    }

    /**
     * @param array $seeInResponse
     */
    public function setSeeInResponse(array $seeInResponse): void
    {
        $this->seeInResponse = $seeInResponse;
    }
}

