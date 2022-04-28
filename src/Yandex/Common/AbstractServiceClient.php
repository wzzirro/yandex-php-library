<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\Common;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\Response;
use Yandex\Common\Exception\MissedArgumentException;
use Yandex\Common\Exception\ProfileNotFoundException;
use Yandex\Common\Exception\YandexException;

/**
 * Class AbstractServiceClient
 *
 * @package Yandex\Common
 *
 * @author   Eugene Zabolotniy <realbaziak@gmail.com>
 * @created  13.09.13 12:09
 */
abstract class AbstractServiceClient extends AbstractPackage
{
    /**
     * Request schemes constants
     */
    const HTTPS_SCHEME = 'https';
    const HTTP_SCHEME = 'http';

    /**
     * @var string
     */
    protected $serviceScheme = self::HTTPS_SCHEME;

    /**
     * Can be HTTP 1.0 or HTTP 1.1
     * @var string
     */
    protected $serviceProtocolVersion = '1.1';

    /**
     * @var string
     */
    protected $serviceDomain = '';

    /**
     * @var string
     */
    protected $servicePort = '';

    /**
     * @var string
     */
    protected $accessToken = '';

    /**
     * @var string
     */
    protected $proxy = '';

    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @var string
     */
    protected $libraryName = 'yandex-php-library';

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->libraryName . '/' . Version::$version;
    }

    /**
     * @param string $accessToken
     *
     * @return self
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param $proxy
     * @return $this
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;

        return $this;
    }

    /**
     * @return string
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param $debug
     * @return $this
     */
    public function setDebug($debug)
    {
        $this->debug = (bool) $debug;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * @param string $serviceDomain
     *
     * @return self
     */
    public function setServiceDomain($serviceDomain)
    {
        $this->serviceDomain = $serviceDomain;

        return $this;
    }

    /**
     * @return string
     */
    public function getServiceDomain()
    {
        return $this->serviceDomain;
    }

    /**
     * @param string $servicePort
     *
     * @return self
     */
    public function setServicePort($servicePort)
    {
        $this->servicePort = $servicePort;

        return $this;
    }

    /**
     * @return string
     */
    public function getServicePort()
    {
        return $this->servicePort;
    }

    /**
     * @param string $serviceScheme
     *
     * @return self
     */
    public function setServiceScheme($serviceScheme = self::HTTPS_SCHEME)
    {
        $this->serviceScheme = $serviceScheme;

        return $this;
    }

    /**
     * @return string
     */
    public function getServiceScheme()
    {
        return $this->serviceScheme;
    }

    /**
     * @param string $resource
     * @return string
     */
    public function getServiceUrl($resource = '')
    {
        return $this->serviceScheme . '://' . $this->serviceDomain . '/' . rawurlencode($resource);
    }

    /**
     * Check package configuration
     *
     * @return boolean
     */
    protected function doCheckSettings()
    {
        return true;
    }

    /**
     * @return \GuzzleHttp\ClientInterface
     */
    protected function getClient()
    {
        $client = new Client();
        if ($this->getProxy()) {
            $client->setDefaultOption('proxy', $this->getProxy());
        }
        if ($this->getDebug()) {
            $client->setDefaultOption('debug', $this->getDebug());
        }
        return $client;
    }

    /**
     * prepareRequest
     *
     * @param \GuzzleHttp\Message\RequestInterface $request
     * @return RequestInterface
     */
    protected function prepareRequest(RequestInterface $request)
    {
        $request->setHeader('Authorization', 'OAuth ' . $this->getAccessToken());
        if (!$request->hasHeader('Host')) {
            $request->setHeader('Host', $this->getServiceDomain());
        }
        $request->setHeader('User-Agent', $this->getUserAgent());
        $request->setHeader('Accept', '*/*');
        return $request;
    }

    /**
     * Sends a request
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface $request
     *
     * @throws Exception\MissedArgumentException
     * @throws Exception\ProfileNotFoundException
     * @throws Exception\YandexException
     * @return Response
     */
    protected function sendRequest(ClientInterface $client, RequestInterface $request)
    {
        try {
            $request = $this->prepareRequest($request);
            $response = $client->send($request);
        } catch (ClientException $ex) {
            // get error from response
            $result = $ex->getResponse()->json();

            // handle a service error message
            if (is_array($result) && isset($result['error'], $result['message'])) {
                switch ($result['error']) {
                    case 'MissedRequiredArguments':
                        throw new MissedArgumentException($result['message']);
                    case 'AssistantProfileNotFound':
                        throw new ProfileNotFoundException($result['message']);
                    default:
                        throw new YandexException($result['message']);
                }
            }

            // unknown error
            throw $ex;
        }

        return $response;
    }
}
