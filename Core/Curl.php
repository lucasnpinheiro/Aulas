<?php

namespace Core;

class Curl {

    public $curl;
    public $url = null;
    public $response = null;
    public $responseCookies = null;
    public $rawResponseHeaders = null;
    public $rawRequestHeaders = null;
    public $requestHeaders = null;
    public $responseHeaders = null;
    public $error = false;
    public $errorCode = 0;
    public $errorMessage = null;
    public $curlError = false;
    public $curlErrorCode = 0;
    public $curlErrorMessage = null;
    public $httpError = false;
    public $httpStatusCode = 0;
    public $httpErrorMessage = null;
    public $cookies = array();
    private $headers = array();
    private $options = array();

    public function __construct() {
        if (!extension_loaded('curl')) {
            throw new \ErrorException('curl library is not loaded');
        }
        $this->curl = curl_init();
        $this->setTimeout(60);
        $this->setOpt(CURLOPT_RETURNTRANSFER, true);
        $this->setOpt(CURLINFO_HEADER_OUT, true);
        $this->setOpt(CURLOPT_HEADERFUNCTION, array($this, 'headerCallback'));
    }

    /**
     * headerCallback
     * @param $ch
     * @param $header
     * @return int
     */
    public function headerCallback($ch, $header) {
        if (preg_match('/^Set-Cookie:\s*([^=]+)=([^;]+)/mi', $header, $cookie) == 1) {
            $this->responseCookies[$cookie[1]] = $cookie[2];
        }
        $this->rawResponseHeaders .= $header;
        return strlen($header);
    }

    /**
     * @param $url
     * @param array $data
     * @return string
     */
    public function get($url, $data = array()) {
        $this->setUrl($url, $data);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'GET');
        $this->setOpt(CURLOPT_HTTPGET, true);
        return $this->exec();
    }

    /**
     * post
     * @param $url
     * @param array $data
     * @return string
     */
    public function post($url, $data = array()) {
        $this->setUrl($url);
        $this->setOpt(CURLOPT_POST, true);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'POST');
        $this->setOpt(CURLOPT_POSTFIELDS, $data);
        return $this->exec();
    }

    /**
     * put
     * @param $url
     * @param array $data
     * @return string
     */
    public function put($url, $data = array()) {
        $this->setURL($url);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'PUT');
        $this->setOpt(CURLOPT_POSTFIELDS, $data);
        return $this->exec();
    }

    /**
     * delete
     * @param $url
     * @param array $data
     * @return string
     */
    public function delete($url, $data = array()) {
        $this->setURL($url);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->setOpt(CURLOPT_POSTFIELDS, $data);
        return $this->exec();
    }

    /**
     * head
     * @param $url
     * @param array $data
     * @return mixed|null
     */
    public function head($url, $data = array()) {
        $this->setURL($url, $data);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'HEAD');
        $this->setOpt(CURLOPT_NOBODY, true);
        return $this->exec();
    }

    /**
     * options
     * @param $url
     * @param array $data
     * @return mixed|null
     */
    public function options($url, $data = array()) {
        $this->setURL($url, $data);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'OPTIONS');
        return $this->exec();
    }

    /**
     * patch
     * @param $url
     * @param array $data
     * @return mixed|null
     */
    public function patch($url, $data = array()) {
        $this->setURL($url);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'PATCH');
        $this->setOpt(CURLOPT_POSTFIELDS, $data);
        return $this->exec();
    }

    /**
     * Download
     *
     * @param $url
     * @param $filename
     * @return bool
     */
    function download($url, $filename) {
        $fp = fopen($filename, "wb");
        if (is_resource($fp)) {
            $this->setOpt(CURLOPT_FILE, $fp);
            $this->get($url);
            fclose($fp);
            return !$this->error;
        }
        return false;
    }

    /**
     * buildUrl
     * @param string $url
     * @param array $data
     * @return string
     */
    public function buildUrl($url = '', $data = array()) {
        return $url . (empty($data) ? '' : '?' . http_build_query($data));
    }

    /**
     * setUrl
     * @param string $url
     * @param array $data
     */
    private function setUrl($url = '', $data = array()) {
        $this->url = $this->buildUrl($url, $data);
        curl_setopt($this->curl, CURLOPT_URL, $this->url);
    }

    /**
     * setOpt
     * @param $option
     * @param $value
     * @return bool
     */
    public function setOpt($option, $value) {
        $required_options = array(
            CURLOPT_RETURNTRANSFER => "CURLOPT_RETURNTRANSFER",
        );
        if (in_array($option, array_keys($required_options), true) && !($value === true)) {
            trigger_error($required_options[$option] . ' is a required option', E_USER_WARNING);
        }
        $this->options[$option] = $value;
        return curl_setopt($this->curl, $option, $value);
    }

    /**
     * setPort
     * @param $port
     */
    public function setPort($port) {
        $this->setOpt(CURLOPT_PORT, intval($port));
    }

    /**
     * setHeader
     * @param $key
     * @param $value
     */
    public function setHeader($key, $value) {
        $this->headers[$key] = $value;
        $headers = array();
        foreach ($this->headers as $key => $value) {
            $headers[] = $key . ': ' . $value;
        }
        $this->setOpt(CURLOPT_HTTPHEADER, $headers);
    }

    /**
     * setUserAgent
     * @param $user_agent
     */
    public function setUserAgent($user_agent) {
        $this->setOpt(CURLOPT_USERAGENT, $user_agent);
    }

    /**
     * setTimeout
     * @param $seconds
     */
    public function setTimeout($seconds) {
        $this->setOpt(CURLOPT_TIMEOUT, $seconds);
    }

    /**
     * setConnectTimeout
     * @param $seconds
     */
    public function setConnectTimeout($seconds) {
        $this->setOpt(CURLOPT_CONNECTTIMEOUT, $seconds);
    }

    /**
     * setCookie
     * @param $key
     * @param $value
     */
    public function setCookie($key, $value) {
        $this->cookies[$key] = $value;
        $cookies = null;
        foreach ($this->cookies as $k => $v) {
            $cookies .= $k . '=' . $v . '; ';
        }
        $this->setOpt(CURLOPT_COOKIE, $cookies);
    }

    /**
     * setCookieFile
     * @param $cookie_file
     */
    public function setCookieFile($cookie_file) {
        $this->setOpt(CURLOPT_COOKIEFILE, $cookie_file);
    }

    /**
     * setCookieJar
     * @param $cookie_jar
     */
    public function setCookieJar($cookie_jar) {
        $this->setOpt(CURLOPT_COOKIEJAR, $cookie_jar);
    }

    /**
     * setReferer
     * @param $referer
     */
    public function setReferer($referer) {
        $this->setOpt(CURLOPT_REFERER, $referer);
    }

    /**
     * setAuthBasic
     * @param $username
     * @param $password
     */
    public function setAuthBasic($username, $password = null) {
        $this->setOpt(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $this->setOpt(CURLOPT_USERPWD, $username . ':' . $password);
    }

    /**
     * setAuthDigest
     * @param $username
     * @param $password
     */
    public function setAuthDigest($username, $password = null) {
        $this->setOpt(CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        $this->setOpt(CURLOPT_USERPWD, $username . ':' . $password);
    }

    /**
     * exec
     * @return mixed|null
     */
    private function exec() {
        $this->response = curl_exec($this->curl);
        $this->curlErrorCode = curl_errno($this->curl);
        $this->curlErrorMessage = curl_error($this->curl);
        $this->curlError = !($this->curlErrorCode === 0);

        $this->httpStatusCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $this->httpError = in_array(floor($this->httpStatusCode / 100), array(4, 5));

        $this->error = $this->curlError || $this->httpError;
        $this->errorCode = $this->error ? ($this->curlError ? $this->curlErrorCode : $this->httpStatusCode) : 0;

        $this->rawRequestHeaders = curl_getinfo($this->curl, CURLINFO_HEADER_OUT);

        $this->requestHeaders = $this->parseRequestHeaders($this->rawRequestHeaders);
        $this->responseHeaders = $this->parseResponseHeaders($this->rawResponseHeaders);

        if ($this->error) {
            $this->httpErrorMessage = $this->responseHeaders[0];
        }
        $this->errorMessage = $this->curlError ? $this->curlErrorMessage : $this->httpErrorMessage;
        return $this->response;
    }

    private function parseRequestHeaders($raw_request_headers) {
        $request_headers_array = explode("\r\n", trim($raw_request_headers));
        return $request_headers_array;
    }

    private function parseResponseHeaders($raw_response_headers) {
        $response_header_array = explode("\r\n", trim($raw_response_headers));
        return $response_header_array;
    }

    /**
     * close
     */
    public function close() {
        if (is_resource($this->curl)) {
            curl_close($this->curl);
        }
    }

    /**
     * destruct
     */
    public function __destruct() {
        $this->close();
    }

}
