<?php

namespace DDM\Api\SmartyStreets;

class SmartyStreetsClient extends \Zend_Http_Client
{

    protected $lastResourcePath = null;

    protected $baseUri = null;

    protected $clientConfig = array();

    protected $localIniKey = 'api';

    protected $clientConfigParams = array(
        'authId'    => 1,
        'authToken' => 1
    );

    /**
     * Constructor method. Will create a new HTTP client. Accepts the target
     * URL and optionally configuration array.
     *
     * @param Zend_Uri_Http|string $uri
     * @param array $config Configuration key-value pairs.
     */
    public function __construct($uri = null, $config = array())
    {

        // If not explicitly set use app ini settings
        $config = $this->initClientConfig($config);

        // Extract Client Config
        $config = $this->extractClientConfig($config);

        // Set default adaptor
        if (! isset($config['adapter'])) {
            $config['adapter'] = 'Zend_Http_Client_Adapter_Curl';
        }

        parent::__construct($uri, $config);

    }

    /**
     * Send the HTTP request and return an HTTP response object
     *
     * @param string $method
     * @return Zend_Http_Response
     * @throws Zend_Http_Client_Exception
     */
    public function request($method = null)
    {

        $this->injectAuthParams();

        $response = parent::request($method);

        return $response;
    }

    /**
     * Adds auth id and token to request
     */
    public function injectAuthParams()
    {
        // Add in auth id and token
        $this->setParameterGet('auth-id', $this->config['authId']);
        $this->setParameterGet('auth-token', $this->config['authToken']);
    }

    /**
     * Set base API uri. This is used to construct API paths
     *
     * @param string $uri
     */
    public function setBaseUri($uri)
    {
        $this->baseUri = $uri;
    }

    /**
     * Return API base URI
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * Set configuration parameters for this HTTP client
     *
     * @param  array $config
     * @return Local_Api_Client_Abstract
     * @throws Zend_Http_Client_Exception
     */
    public function setConfig($config = array())
    {
        // Extract client config
        if (count($config)) {
            $config = $this->extractClientConfig($config);
        }

        parent::setConfig($config);

        return $this;
    }

    /**
     * Getter for config
     * @return array
     */
    public function getConfig()
    {

    }

    /**
     * Build full API resource path and set clients current URI
     *
     * @param string $path
     * @param string $base
     * @return Local_Api_Client_Abstract
     */
    public function setApiUri($resourcePath, $base=null)
    {
        if (is_null($base)) {
            $base = $this->getBaseUri();
        }

        // Trim / from front of path
        $resourcePath = ltrim($resourcePath, '/');

        // Store last resource path
        $this->lastResourcePath = $resourcePath;

        $this->setUri($base. $resourcePath);

        return $this;
    }

    /**
     * Get the full URI including queryParams for the next request
     *
     * @param boolean $as_string If true, will return the URI as a string
     * @return mixed Zend_Uri_Http|string
     */
    public function getFullUri($asString=false)
    {
        // Clone the URI and add the additional GET parameters to it
        if (is_null($this->uri)) {
            return ($asString)? 'uri not set' : $this->uri;
        }

        $uri = clone $this->uri;
        if (! empty($this->paramsGet)) {
            $query = $uri->getQuery();
            if (! empty($query)) {
                $query .= '&';
            }
            $query .= http_build_query($this->paramsGet, null, '&');
            if ($this->config['rfc3986_strict']) {
                $query = str_replace('+', '%20', $query);
            }

            $uri->setQuery($query);
        }

        if ($asString) {
            return $uri->__toString();
        }

        return $uri;
    }

    /**
     * Merges application ini settings with config. App ini settings only used if
     * not explicitly set in config
     *
     * @param array|obj $config
     */
    protected function initClientConfig($config)
    {
        if (! isset($local[$this->localIniKey])) {
            return $config;
        }

        return array_merge($local[$this->localIniKey], $config);

    }

    /**
     * Extract client config params from general config.
     * Client config is stored in clientConfig array
     *
     * @param array $config
     * @param boolean $verifyConfig if true config will be verified
     * @return array $config
     * @throws Local_Api_Client_Exception
     */
    protected function extractClientConfig($config, $verifyConfig=true)
    {

        foreach (array_keys($this->clientConfigParams) as $key) {
            if (isset($config[$key])) {
                $this->clientConfig[$key] = $config[$key];
                unset($config[$key]);
            }
        }

        // Read in API specific config
        if (isset($config['baseUri'])) {
            $this->baseUri = rtrim($config['baseUri'], '/');
            $this->baseUri .= '/';
            $this->clientConfig['baseUri'] = $this->baseUri;
            unset($config['baseUri']);
        }

        if ($verifyConfig) {
            $this->verifyClientConfig();
        }

        return $config;
    }

    /**
     * Check that all required config params are present.
     * Probably could be turned off in production.
     *
     * @param array $config
     * @throws Local_Api_Client_Exception
     */
    protected function verifyClientConfig()
    {

        // Iterate through client specific params
        foreach($this->clientConfigParams as $key => $required) {
            if ($required
                && (! isset($this->clientConfig[$key]) || is_null($this->clientConfig[$key])) ) {
                throw new \Exception('Missing required param: '. $key);
            }
        }

        // Make sure that we have a base uri
        if (is_null($this->baseUri)) {
            throw new \Exception('Base URI cannot be null.');
        }
    }

}