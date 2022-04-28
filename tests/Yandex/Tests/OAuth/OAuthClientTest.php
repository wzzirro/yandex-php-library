<?php

namespace Yandex\Tests\OAuth;

use Yandex\OAuth\OAuthClient;
use Yandex\Tests\TestCase;

class OAuthClientTest extends TestCase
{
    public function testCreate()
    {
        $this->getOauthClient();
    }

    public function testGetClient()
    {
        $oauthClient = $this->getOauthClient();

        $getClient = self::getNotAccessibleMethod($oauthClient, 'getClient');

        $guzzleClient = $getClient->invokeArgs($oauthClient, []);

        $this->assertInstanceOf('\GuzzleHttp\ClientInterface', $guzzleClient);
    }

    /**
     * @param $accessToken
     * @param $expectedAccessToken
     *
     * @dataProvider dataSetGetAccessToken
     */
    public function testSetGetAccessToken($accessToken, $expectedAccessToken)
    {
        $oauthClient = $this->getOauthClient();

        $this->assertEmpty($oauthClient->getAccessToken());

        $oauthClient->setAccessToken($accessToken);

        $this->assertEquals($expectedAccessToken, $oauthClient->getAccessToken());
    }

    /**
     * @return array
     */
    public function dataSetGetAccessToken()
    {
        return [
            'empty access token' => [
                'accessToken' => null,
                'expectedAccessToken' => null
            ],
            'not empty access token' => [
                'accessToken' => 'test',
                'expectedAccessToken' => 'test'
            ],
        ];
    }

    /**
     * @param $serviceDomain
     * @param $expectedServiceDomain
     *
     * @dataProvider dataSetGetServiceDomain
     */
    public function testSetGetServiceDomain($serviceDomain, $expectedServiceDomain)
    {
        $oauthClient = $this->getOauthClient();

        $this->assertNotEmpty($oauthClient->getServiceDomain());

        $oauthClient->setServiceDomain($serviceDomain);

        $this->assertEquals($expectedServiceDomain, $oauthClient->getServiceDomain());
    }

    /**
     * @return array
     */
    public function dataSetGetServiceDomain()
    {
        return [
            'empty service domain' => [
                'serviceDomain' => null,
                'expectedServiceDomain' => null
            ],
            'not empty service domain' => [
                'serviceDomain' => 'test',
                'expectedServiceDomain' => 'test'
            ],
        ];
    }

    /**
     * @param $servicePort
     * @param $expectedServicePort
     *
     * @dataProvider dataSetGetServicePort
     */
    public function testSetGetServicePort($servicePort, $expectedServicePort)
    {
        $oauthClient = $this->getOauthClient();

        $this->assertEmpty($oauthClient->getServicePort());

        $oauthClient->setServicePort($servicePort);

        $this->assertEquals($expectedServicePort, $oauthClient->getServicePort());
    }

    /**
     * @return array
     */
    public function dataSetGetServicePort()
    {
        return [
            'empty service port' => [
                'servicePort' => null,
                'expectedServicePort' => null
            ],
            'not empty service port' => [
                'servicePort' => 'test',
                'expectedServicePort' => 'test'
            ],
        ];
    }

    /**
     * @param $serviceScheme
     * @param $expectedServiceScheme
     *
     * @dataProvider dataSetGetServiceScheme
     */
    public function testSetGetServiceScheme($serviceScheme, $expectedServiceScheme)
    {
        $oauthClient = $this->getOauthClient();

        $this->assertNotEmpty($oauthClient->getServiceScheme());

        $oauthClient->setServiceScheme($serviceScheme);

        $this->assertEquals($expectedServiceScheme, $oauthClient->getServiceScheme());
    }

    /**
     * @param $resource
     * @param $expectedServiceUrl
     *
     * @dataProvider dataGetServiceUrl
     */
    public function testGetServiceUrl($resource, $expectedServiceUrl)
    {
        $oauthClient = $this->getOauthClient();

        $this->assertEquals($expectedServiceUrl, $oauthClient->getServiceUrl($resource));
    }

    /**
     * @return array
     */
    public function dataGetServiceUrl()
    {
        return [
            'empty service resource' => [
                'resource' => null,
                'expectedServiceUrl' => 'https://oauth.yandex.ru/'
            ],
            'not empty service resource' => [
                'resource' => 'test',
                'expectedServiceUrl' => 'https://oauth.yandex.ru/test'
            ],
        ];
    }

    /**
     * @return array
     */
    public function dataSetGetServiceScheme()
    {
        return [
            'empty service scheme' => [
                'serviceScheme' => null,
                'expectedServiceScheme' => null
            ],
            'not empty service scheme' => [
                'serviceScheme' => 'test',
                'expectedServiceScheme' => 'test'
            ],
        ];
    }

    /**
     * @param string $cleintId
     * @return OAuthClient
     */
    private function getOauthClient($cleintId = 'test')
    {
        return new OAuthClient($cleintId);
    }
}