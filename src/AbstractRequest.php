<?php

namespace DDM\SmartyStreets;

use Zend\Http\Client as ZendHttpClient;

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
   * [$authToken description]
   * @var [type]
   */
  protected $authToken;

  /**
   * [$authId description]
   * @var [type]
   */
  protected $authId;

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
  public function __construct($authToken, $authId, \Zend\Http\Client $client = null)
  {
      $this->setAuthToken($authToken);
      $this->setAuthId($authId);

      if(!is_null($client)){
        $this->client = $client;
      }
  }

  /**
   * [setAuthToken description]
   * @param [type] $authToken [description]
   */
  public function setAuthToken($authToken)
  {
    $this->authToken = $authToken;
    $this->setQueryParam('auth-token', $authToken);
  }

  /**
   * [setAuthId description]
   * @param [type] $authId [description]
   */
  public function setAuthId($authId)
  {
    $this->authId = $authId;
    $this->setQueryParam('auth-id', $authId);
  }

  /**
   * [getDefaultClient description]
   */
  public function getDefaultClient()
  {
    return new ZendHttpClient(
      ['base_url' => $this->baseUrl]
    );
  }

  /**
   * Set the client
   * @param \Zend\Http\Client $client
   */
  public function setClient(\Zend\Http\Client $client)
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
    $options = [
        'query'   => $this->getQueryParams(),
        'headers' => $this->getHeaders(),
        'body'    => $this->getBody(),
    ];
    $bodyAsString = true;
    $result = json_decode($client->post($this->endpoint,$options)->getBody($bodyAsString));
    $response = $this->getResponse();
    $response->setBody($result);

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
}
