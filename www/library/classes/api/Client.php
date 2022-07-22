<?php

/**
 * Quickly and easily access any REST or REST-like API.
 * 
 * @author    Mzimhle Mosiwe
 *
 * @method Response get($body = null, $query = null, $headers = null)
 * @method Response post($body = null, $query = null, $headers = null)
 * @method Response patch($body = null, $query = null, $headers = null)
 * @method Response put($body = null, $query = null, $headers = null)
 * @method Response delete($body = null, $query = null, $headers = null)
 *
 */
class Client
{
    /** @var string */
    protected $host;
    /** @var array */
    protected $headers;
    /** @var string */
    protected $version;
    /** @var array */
    protected $path;
    /** @var array */
    protected $curlOptions;
    /** @var bool */
    protected $retryOnLimit;

    /**
     * These are the supported HTTP verbs
     *
     * @var array
     */
    private $methods = ['get', 'post', 'patch',  'put', 'delete'];

    /**
      * Initialize the client
      *
      * @param string  $host     the base url (e.g. https://interview-assessment-1.realmdigital.co.za/)
      * @param array   $headers  global request headers
      * @param array   $path     holds the segments of the url path
      */
    public function __construct($host, $headers = [], $path = [])
    {
        $this->host = $host;
        $this->headers = $headers;
        $this->path = $path;

        $this->curlOptions = [];
        $this->retryOnLimit = false;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getPath(): array
    {
        return $this->path;
    }

    /**
     * Set extra options to set during curl initialization
     *
     * @param array $options
     *
     * @return Client
     */
    public function setCurlOptions(array $options)
    {
        $this->curlOptions = $options;
        return $this;
    }

    /**
     * Set default retry on limit flag
     *
     * @param bool $retry
     *
     * @return Client
     */
    public function setRetryOnLimit($retry)
    {
        $this->retryOnLimit = $retry;

        return $this;
    }

    /**
     * @return array
     */
    public function getCurlOptions()
    {
        return $this->curlOptions;
    }

    /**
      * Build the final URL to be passed
      *
      * @param array $queryParams an array of all the query parameters
      *
      * @return string
      */
    private function buildUrl($queryParams = null)
    {
        $path = '/' . implode('/', $this->path);
        if (isset($queryParams)) {
            $path .= '?' . http_build_query($queryParams);
        }
        return sprintf('%s%s%s', $this->host, $this->version ?: '', $path);
    }

    /**
      * Make the API call and return the response. This is separated into
      * it's own function, so we can mock it easily for testing.
      *
      * @param string $method       the HTTP verb
      * @param string $url          the final url to call
      * @param array  $body         request body
      * @param array  $headers      any additional request headers
      * @param bool   $retryOnLimit should retry if rate limit is reach?
      *
      * @return Response object
      */
    public function makeRequest($method, $url, $body = null, $headers = null, $retryOnLimit = false)
    {
        $curl = curl_init($url);

        $options = array_merge(
            [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => 1,
                CURLOPT_CUSTOMREQUEST => strtoupper($method),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FAILONERROR => false,
            ],
            $this->curlOptions
        );

        curl_setopt_array($curl, $options);

        if (isset($headers)) {
            $this->headers = array_merge($this->headers, $headers);
        }
        if (isset($body)) {
            $encodedBody = json_encode($body);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $encodedBody);
            $this->headers = array_merge($this->headers, ['Content-Type: application/json']);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($curl);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $responseBody = substr($response, $headerSize);
        $responseHeaders = substr($response, 0, $headerSize);

        $responseHeaders = explode("\n", $responseHeaders);
        $responseHeaders = array_map('trim', $responseHeaders);

        curl_close($curl);
     
        $response = new Response($statusCode, $responseBody, $responseHeaders);

        if ($statusCode === 429 && $retryOnLimit) {
            $headers = $response->headers(true);
            $sleepDurations = $headers['X-Ratelimit-Reset'] - time();
            sleep($sleepDurations > 0 ? $sleepDurations : 0);
            return $this->makeRequest($method, $url, $body, $headers, false);
        }

        return $response;
    }

    /**
      * Add variable values to the url.
      * (e.g. /your/api/{variable_value}/call)
      * Another example: if you have a PHP reserved word, such as and,
      * in your url, you must use this method.
      *
      * @param string $name name of the url segment
      *
      * @return Client object
      */
    public function _($name = null)
    {
        if (isset($name)) {
            $this->path[] = $name;
        }
        $client = new static($this->host, $this->headers, $this->path);
        $client->setCurlOptions($this->curlOptions);
        $client->setRetryOnLimit($this->retryOnLimit);
        $this->path = [];

        return $client;
    }

    /**
      * Dynamically add method calls to the url, then call a method.
      * (e.g. client.name.name.method())
      *
      * @param string $name name of the dynamic method call or HTTP verb
      * @param array  $args parameters passed with the method call
      *
      * @return Client|Response object
      */
    public function __call($name, $args)
    {
        $name = strtolower($name);

        if (in_array($name, $this->methods, true)) {
            $body = isset($args[0]) ? $args[0] : null;
            $queryParams = isset($args[1]) ? $args[1] : null;
            $url = $this->buildUrl($queryParams);
            $headers = isset($args[2]) ? $args[2] : null;
            $retryOnLimit = isset($args[3]) ? $args[3] : $this->retryOnLimit;
            return $this->makeRequest($name, $url, $body, $headers, $retryOnLimit);
        }

        return $this->_($name);
    }
}
