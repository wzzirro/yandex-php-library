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
namespace Yandex\Metrica;

use GuzzleHttp\ClientInterface;
use Yandex\Common\AbstractServiceClient;
use GuzzleHttp\Client;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Exception\ClientException;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\UnauthorizedException;
use Yandex\Metrica\Exception\MetricaException;

/**
 * Class MetricaClient
 *
 * @category Yandex
 * @package Metrica
 *
 * @author   Alexander Khaylo <naxel@land.ru>
 * @created  12.02.14 15:46
 */
class MetricaClient extends AbstractServiceClient
{

    /**
     * API domain
     *
     * @var string
     */
    protected $serviceDomain = 'api-metrika.yandex.ru/management/v1';


    /**
     * @param string $token access token
     */
    public function __construct($token = '')
    {
        $this->setAccessToken($token);
    }


    /**
     * Get url to service resource with parameters
     *
     * @param string $resource
     * @param array $params
     * @see http://api.yandex.ru/metrika/doc/ref/concepts/method-call.xml
     * @return string
     */
    public function getServiceUrl($resource = '', $params = array())
    {
        $format = $resource === '' ? '' : '.json';
        $url = $this->serviceScheme . '://' . $this->serviceDomain . '/'
            . $resource . $format . '?oauth_token=' . $this->getAccessToken();

        if ($params) {
            $url .= '&' . http_build_query($params);
        }

        return $url;
    }


    /**
     * Sends a request
     *
     * @param ClientInterface $client
     * @param RequestInterface $request
     * @return Response
     * @throws ForbiddenException
     * @throws UnauthorizedException
     * @throws MetricaException
     */
    protected function sendRequest(ClientInterface $client, RequestInterface $request)
    {
        try {
            $request->setHeader('User-Agent', $this->getUserAgent());
            $response = $client->send($request);

        } catch (ClientException $ex) {

            $result = $ex->getResponse();
            $code = $result->getStatusCode();
            $message = $result->getReasonPhrase();

            if ($code === 403) {
                throw new ForbiddenException($message);
            }

            if ($code === 401) {
                throw new UnauthorizedException($message);
            }

            throw new MetricaException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"'
            );
        }

        return $response;
    }


    /**
     * Get OAuth data for header request
     *
     * @see http://api.yandex.ru/metrika/doc/ref/concepts/result-format.xml
     *
     * @return string
     */
    protected function getOauthData()
    {
        return 'OAuth ' . $this->getAccessToken();
    }


    /**
     * Send GET request to API resource
     *
     * @param string $resource
     * @param array $params
     * @return array
     */
    protected function sendGetRequest($resource, $params = array())
    {
        $client = $this->getClient();
        $request = $client->createRequest(
            'GET',
            $this->getServiceUrl($resource, $params),
            [
                'headers' => [
                    'Authorization' => $this->getOauthData(),
                    'Accept' => 'application/x-yametrika+json',
                    'Content-Type' => 'application/x-yametrika+json',
                ]
            ]
        );
        $response = $this->sendRequest($client, $request)->json();
        if (isset($response['links']) && isset($response['links']['next'])) {
            $url = $response['links']['next'];
            unset($response['rows']);
            unset($response['links']);
            $response = $this->getNextPartOfList($url, $response);
        }
        return $response;
    }


    /**
     * Send custom GET request to API resource
     *
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function getNextPartOfList($url, $data = array())
    {
        $client = $this->getClient();
        $request = $client->createRequest(
            'GET',
            $url,
            [
                'headers' => [
                    'Authorization' => $this->getOauthData(),
                    'Accept' => 'application/x-yametrika+json',
                    'Content-Type' => 'application/x-yametrika+json',
                ]
            ]
        );
        $response = $this->sendRequest($client, $request)->json();

        $response = array_merge_recursive($data, $response);
        if (isset($response['links']) && isset($response['links']['next'])) {
            $url = $response['links'];
            unset($response['rows']);
            unset($response['links']);
            $response = $this->getNextPartOfList($url, $response);
        }

        return $response;
    }


    /**
     * Send POST request to API resource
     *
     * @param string $resource
     * @param array $params
     * @return array
     */
    protected function sendPostRequest($resource, $params)
    {
        $client = $this->getClient();

        $request = $client->createRequest(
            'POST',
            $this->getServiceUrl($resource),
            [
                'headers' => [
                    'Authorization' => $this->getOauthData(),
                    'Accept' => 'application/x-yametrika+json',
                    'Content-Type' => 'application/x-yametrika+json',
                ],
                'body' => json_encode($params)
            ]
        );

        $response = $this->sendRequest($client, $request)->json();
        return $response;
    }


    /**
     * Send PUT request to API resource
     *
     * @param string $resource
     * @param array $params
     * @return array
     */
    protected function sendPutRequest($resource, $params)
    {
        $client = $this->getClient();

        $request = $client->createRequest(
            'PUT',
            $this->getServiceUrl($resource),
            [
                'headers' => [
                    'Authorization' => $this->getOauthData(),
                    'Accept' => 'application/x-yametrika+json',
                    'Content-Type' => 'application/x-yametrika+json',
                ],
                'body' => json_encode($params)
            ]
        );

        $response = $this->sendRequest($client, $request)->json();
        return $response;
    }


    /**
     * Send DELETE request to API resource
     *
     * @param string $resource
     * @return array
     */
    protected function sendDeleteRequest($resource)
    {
        $client = $this->getClient();

        $request = $client->createRequest(
            'DELETE',
            $this->getServiceUrl($resource),
            [
                'headers' => [
                    'Authorization' => $this->getOauthData(),
                    'Accept' => 'application/x-yametrika+json',
                    'Content-Type' => 'application/x-yametrika+json',
                ]
            ]
        );

        $response = $this->sendRequest($client, $request)->json();
        return $response;
    }
}
