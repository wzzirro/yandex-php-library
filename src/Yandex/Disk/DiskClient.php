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
namespace Yandex\Disk;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Exception\ClientException;
use Yandex\Common\AbstractServiceClient;
use Yandex\Disk\Exception\DiskRequestException;

/**
 * Class DiskClient
 *
 * @category Yandex
 * @package Disk
 *
 * @author   Alexander Mitsura <mitsuraa@gmail.com>
 * @created  07.10.13 12:35
 */
class DiskClient extends AbstractServiceClient
{
    /**
     * @var string
     */
    private $version = 'v1';

    /**
     * @var string
     */
    protected $serviceDomain = 'webdav.yandex.ru';

    /**
     * @param string $version
     *
     * @return self
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @inheritdoc
     */
    public function getServiceUrl($resource = '')
    {
        return parent::getServiceUrl($resource) . '/' . $this->version;
    }

    /**
     * @param $path
     * @return string
     */
    public function getRequestUrl($path)
    {
        return parent::getServiceUrl() . $path;
    }

    /**
     * @param string $token access token
     */
    public function __construct($token = '')
    {
        $this->setAccessToken($token);
    }

    /**
     * Sends a request
     *
     * @param RequestInterface $request
     *
     * @throws \Exception|\GuzzleHttp\Exception\ClientException
     * @return Response
     */
    protected function sendRequest(ClientInterface $client, RequestInterface $request)
    {
        try {
            $request = $this->prepareRequest($request);
            $response = $client->send($request);
        } catch (ClientException $ex) {
            $result = $ex->getResponse();
            $code = $result->getStatusCode();
            $message = $result->getReasonPhrase();

            throw new DiskRequestException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"',
                $code
            );
        }

        return $response;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function createDirectory($path = '')
    {
        $client = $this->getClient();
        $request = $client->createRequest('MKCOL', $this->getServiceUrl());
        $request->setPath($path);
        return (bool)$this->sendRequest($client, $request);
    }

    /**
     * @param string $path
     * @param null $offset
     * @param null $amount
     * @return array
     */
    public function directoryContents($path = '', $offset = null, $amount = null)
    {
        $client = $this->getClient();
        $request = $client->createRequest('PROPFIND', $this->getServiceUrl());
        $request->setPath($path);
        $request->setHeader('Depth', '1');

        if (isset($offset, $amount)) {
            $request->getQuery()->set('offset', $offset);
            $request->getQuery()->set('amount', $amount);
        }

        $xml = $this->sendRequest($client, $request)->xml()->children('DAV:');

        $contents = array();
        foreach ($xml as $element) {
            array_push(
                $contents,
                array(
                    'href' => $element->href->__toString(),
                    'status' => $element->propstat->status->__toString(),
                    'creationDate' => $element->propstat->prop->creationdate->__toString(),
                    'lastModified' => $element->propstat->prop->getlastmodified->__toString(),
                    'displayName' => $element->propstat->prop->displayname->__toString(),
                    'contentLength' => $element->propstat->prop->getcontentlength->__toString(),
                    'resourceType' => $element->propstat->prop->resourcetype->collection ? 'dir' : 'file',
                    'contentType' => $element->propstat->prop->getcontenttype->__toString()
                )
            );
        }
        return $contents;
    }

    /**
     * @return array
     */
    public function diskSpaceInfo()
    {
        $client = $this->getClient();

        $body = '<?xml version="1.0" encoding="utf-8" ?><D:propfind xmlns:D="DAV:">
            <D:prop><D:quota-available-bytes/><D:quota-used-bytes/></D:prop></D:propfind>';

        $request = $client->createRequest(
            'PROPFIND',
            $this->getServiceUrl(),
            [
                'headers' => [
                    'Depth' => '0'
                ],
                'body' => $body
            ]
        );
        $request->setPath('/');

        $result = $this->sendRequest($client, $request)->xml()->children('DAV:');
        $info = (array)$result->response->propstat->prop;
        return array(
            'usedBytes' => $info['quota-used-bytes'],
            'availableBytes' => $info['quota-available-bytes']
        );
    }

    /**
     * @param string $path
     * @param string $property
     * @param string $value
     * @param string $namespace
     * @return bool
     */
    public function setProperty($path = '', $property = '', $value = '', $namespace = 'default:namespace')
    {
        if (!empty($property) && !empty($value)) {
            $client = $this->getClient();

            $body = '<?xml version="1.0" encoding="utf-8" ?><propertyupdate xmlns="DAV:" xmlns:u="'
                . $namespace . '"><set><prop><u:' . $property . '>' . $value . '</u:'
                . $property . '></prop></set></propertyupdate>';

            $request = $client->createRequest(
                'PROPPATCH',
                $this->getServiceUrl(),
                [
                    'headers' => [
                        'Content-Length' => strlen($body),
                        'Content-Type' => 'application/x-www-form-urlencoded'
                    ],
                    'body' => $body
                ]
            );
            $request->setPath('/');

            $response = $this->sendRequest($client, $request)->xml()->children('DAV:')->response;
            $resultStatus = $response->propstat->status;
            if (strpos($resultStatus, '200 OK')) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $path
     * @param string $property
     * @param string $namespace
     * @return string|false
     */
    public function getProperty($path = '', $property = '', $namespace = 'default:namespace')
    {
        if (!empty($property)) {
            $client = $this->getClient();

            $body = '<?xml version="1.0" encoding="utf-8" ?><propfind xmlns="DAV:"><prop><' . $property
                . ' xmlns="' . $namespace . '"/></prop></propfind>';

            $request = $client->createRequest(
                'PROPFIND',
                $this->getServiceUrl(),
                [
                    'headers' => [
                        'Depth' => '1',
                        'Content-Length' => strlen($body),
                        'Content-Type' => 'application/x-www-form-urlencoded'
                    ],
                    'body' => $body
                ]
            );
            $request->setPath($path);

            $result = $this->sendRequest($client, $request);
            $response = $result->xml()->children('DAV:')->response;
            $resultStatus = $response->propstat->status;
            if (strpos($resultStatus, '200 OK')) {
                return (string)$response->propstat->prop->children();
            }
        }

        return false;
    }

    /**
     * @return string
     * @see https://tech.yandex.com/disk/doc/dg/reference/userinfo-docpage/
     */
    public function getLogin()
    {
        $client = $this->getClient();
        $request = $client->createRequest(
            'GET',
            parent::getServiceUrl() . '?userinfo'
        );

        $response = $this->sendRequest($client, $request);
        $result = explode(":", $response->getBody());
        array_shift($result);
        return implode(':', $result);
    }

    /**
     * @param string $path
     * @return array
     */
    public function getFile($path = '')
    {
        $result = array();
        $client = $this->getClient();
        $request = $client->createRequest('GET', $this->getServiceUrl());
        $request->setPath($path);

        $response = $this->sendRequest($client, $request);
        $headers = $response->getHeaders();
        foreach ($headers as $key => $value) {
            $result['headers'][strtolower($key)] = $value[0];
        }
        $result['body'] = $response->getBody();
        return $result;
    }

    /**
     * @param string $path
     * @param string $destination
     * @param string $name
     * @return string|false
     */
    public function downloadFile($path = '', $destination = '', $name = '')
    {
        $client = $this->getClient();
        $request = $client->createRequest('GET', $this->getServiceUrl());
        $request->setPath($path);
        $response = $this->sendRequest($client, $request);

        if ($name === '') {
            $matchResults = array();
            preg_match(
                "/.*?filename=\"(.*?)\".*?/",
                (string) $response->getHeader('Content-Disposition'),
                $matchResults
            );
            $name = urldecode($matchResults[1]);
        }

        $file = $destination . $name;

        $result = file_put_contents($file, $response->getBody()) ? $file : false;

        return $result;
    }

    /**
     * @param string $path
     * @param array $file
     * @param array $extraHeaders
     * @return void
     */
    public function uploadFile($path = '', $file = null, $extraHeaders = null)
    {
        if (file_exists($file['path'])) {
            $headers = array(
                'Content-Length' => (string)$file['size']
            );
            $finfo = finfo_open(FILEINFO_MIME);
            $mime = finfo_file($finfo, $file['path']);
            $parts = explode(";", $mime);
            $headers['Content-Type'] = $parts[0];
            $headers['Etag'] = md5_file($file['path']);
            $headers['Sha256'] = hash_file('sha256', $file['path']);
            $headers = isset($extraHeaders) ? array_merge($headers, $extraHeaders) : $headers;

            $client = $this->getClient();
            $request = $client->createRequest(
                'PUT',
                $this->getServiceUrl(),
                [
                    'headers' => $headers,
                    'body' => fopen($file['path'], 'rb'),
                    'expect' => true
                ]
            );
            $request->setPath($path . $file['name']);
            $this->sendRequest($client, $request);
        }
    }

    /**
     * @param $path
     * @param $size
     * @return array
     */
    public function getImagePreview($path, $size)
    {
        $result = array();
        $client = $this->getClient();
        $request = $client->createRequest('GET', $this->getServiceUrl());
        $request->setPath($path);
        $request->getQuery()->set('preview', null);
        $request->getQuery()->set('size', $size);
        $response = $this->sendRequest($client, $request);

        $headers = $response->getHeaders();
        foreach ($headers as $key => $value) {
            $result['headers'][strtolower($key)] = $value[0];
        }

        $result['body'] = $response->getBody();
        return $result;
    }

    /**
     * @param string $target
     * @param string $destination
     * @return bool
     */
    public function copy($target = '', $destination = '')
    {
        $client = $this->getClient();
        $request = $client->createRequest('COPY', $this->getServiceUrl());
        $request->setPath($target);
        $request->setHeader('Destination', $destination);
        return (bool)$this->sendRequest($client, $request);
    }

    /**
     * @param string $path
     * @param string $destination
     * @return bool
     */
    public function move($path = '', $destination = '')
    {
        $client = $this->getClient();
        $request = $client->createRequest('MOVE', $this->getServiceUrl());
        $request->setPath($path);
        $request->setHeader('Destination', $destination);
        return (bool)$this->sendRequest($client, $request);
    }

    /**
     * @param string $path
     * @return bool
     */
    public function delete($path = '')
    {
        $client = $this->getClient();
        $request = $client->createRequest('DELETE', $this->getServiceUrl());
        $request->setPath($path);
        return (bool)$this->sendRequest($client, $request);
    }

    /**
     * @param string $path
     * @return string
     */
    public function startPublishing($path = '')
    {
        $client = $this->getClient();

        $body = '<propertyupdate xmlns="DAV:"><set><prop>
            <public_url xmlns="urn:yandex:disk:meta">true</public_url>
            </prop></set></propertyupdate>';

        $request = $client->createRequest(
            'PROPPATCH',
            $this->getServiceUrl(),
            [
                'headers' => [
                    'Content-Length' => strlen($body)
                ],
                'body' => $body
            ]
        );
        $request->setPath($path);

        $result = $this->sendRequest($client, $request)->xml()->children('DAV:');
        $publicUrl = $result->response->propstat->prop->children()->public_url;
        return (string)$publicUrl;
    }

    /**
     * @param string $path
     * @return void
     */
    public function stopPublishing($path = '')
    {
        $client = $this->getClient();

        $body = '<propertyupdate xmlns="DAV:"><remove><prop>
            <public_url xmlns="urn:yandex:disk:meta" />
            </prop></remove></propertyupdate>';

        $request = $client->createRequest(
            'PROPPATCH',
            $this->getServiceUrl(),
            [
                'headers' => [
                    'Content-Length' => strlen($body)
                ],
                'body' => $body
            ]
        );
        $request->setPath($path);

        $this->sendRequest($client, $request);
    }

    /**
     * @param string $path
     * @return string|bool
     */
    public function checkPublishing($path = '')
    {
        $client = $this->getClient();

        $body = '<propfind xmlns="DAV:"><prop><public_url xmlns="urn:yandex:disk:meta"/></prop></propfind>';

        $request = $client->createRequest(
            'PROPFIND',
            $this->getServiceUrl(),
            [
                'headers' => [
                    'Content-Length' => strlen($body),
                    'Depth' => '0'
                ],
                'body' => $body
            ]
        );
        $request->setPath($path);

        $result = $this->sendRequest($client, $request)->xml()->children('DAV:');
        $propArray = (array)$result->response->propstat->prop->children();
        return empty($propArray['public_url']) ? (bool)false : (string)$propArray['public_url'];
    }
}
