<?php

namespace DDM\SmartyStreets;

use Guzzle\Http\Client as GuzzleClient;

/**
 *
 */
abstract class AbstractRequest
{
    /**
     * [$client description]
     * @var [type]
     */
    protected $client = null;

    /**
     * [$baseUrl description]
     * @var string
     */
    protected $baseUrl = 'https://api.smartystreets.com/';

    /**
     * [$endpoint description]
     * @var string
     */
    protected $endpoint = '';

    /**
     * [$queryParams description]
     * @var [type]
     */
    protected $queryParams = [];

    /**
     * [$headers description]
     * @var [type]
     */
    protected $headers = [];

    /**
     * [$response description]
     * @var [type]
     */
    protected $response  = null;

    /**
     * [__construct description]
     * @param [type] $authToken [description]
     * @param [type] $authId    [description]
     * @param [type] $client    [description]
     */
    public function __construct($authToken, $authId, \Guzzle\Http\Client $client = null)
    {
        $this->setQueryParam('auth-token', $authToken);
        $this->setQueryParam('auth-id', $authId);

        if(!is_null($client)){
          $this->client = $client;
        }
    }

    /**
     * [getDefaultClient description]
     */
    public function getDefaultClient()
    {
        return new GuzzleClient($this->baseUrl);
    }

    /**
     * Set the client
     * @param \GuzzleHttp\Client $client
     */
    public function setClient(\Guzzle\Http\Client $client)
    {
        $this->client = $client;
    }

    /**
     * [getClient description]
     */
    public function getClient()
    {
        if(is_null($this->client)){
            $this->client = $this->getDefaultClient();
        }
        return $this->client;
    }

    /**
     * [getResponse description]
     */
    public function getResponse()
    {
        if(!$this->response){
            $this->response = $this->getDefaultResponse();
        }

        return $this->response;
    }

    /**
     * [getDefaultResponse description]
     */
    abstract public function getDefaultResponse();

    /**
     * [send description]
     * @return [type] [description]
     */
    public function send()
    {
        $client = $this->getClient();

        $requestOptions = $this->getRequestOptions();

        $request = $client->post(
            $this->endpoint,
            null,
            null,
            $requestOptions
        );

        $result = $request->send();

        $bodyAsString = true;
        $resultBody = json_decode($result->getBody($bodyAsString));

        $response = $this->getResponse();
        $response->setBody($resultBody);

        return $response;
    }

    /**
     * [getHeaders description]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * [setQueryParam description]
     * @param [type] $name  [description]
     * @param [type] $value [description]
     */
    public function setQueryParam($name, $value)
    {
        $this->queryParams[$name]=$value;
    }

    /**
     * [getQueryParams description]
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getRequestOptions()
    {
        $options = array(
            'query'   => $this->getQueryParams(),
            'headers' => $this->getHeaders(),
            'body'    => $this->getBody(),
        );

        return $options;
    }

    public function getRequestUri()
    {
        return $this->baseUrl . $this->endpoint;
    }

    /**
     * Getter for baseUrl
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Setter for baseUrl
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }
}
