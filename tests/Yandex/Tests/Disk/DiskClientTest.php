<?php

namespace Yandex\Tests\OAuth;

use Yandex\Disk\DiskClient;
use Yandex\Tests\TestCase;
use Yandex\Disk\Exception\DiskRequestException;

class DiskClientTest extends TestCase
{
    public function testCreate()
    {
        $this->getDiskClient();
    }

    public function testGetClient()
    {
        $diskClient = $this->getDiskClient();

        $getClient = self::getNotAccessibleMethod($diskClient, 'getClient');

        $guzzleClient = $getClient->invokeArgs($diskClient, []);

        $this->assertInstanceOf('\GuzzleHttp\ClientInterface', $guzzleClient);
    }

    public function testDiskRequestExceptionWithCode()
    {
        $diskClient = $this->getDiskClient();

        try {
            $diskClient->createDirectory('test');
            $this->fail('DiskRequestException has not been thrown');
        } catch (DiskRequestException $e) {
            $this->assertEquals(401, $e->getCode());
        }
    }

    /**
     * @param string $token
     * @return DiskClient
     */
    private function getDiskClient($token = 'test')
    {
        return new DiskClient($token);
    }
}