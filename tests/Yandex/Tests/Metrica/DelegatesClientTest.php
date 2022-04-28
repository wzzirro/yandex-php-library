<?php

namespace Yandex\Tests\Metrica;

use Yandex\Tests\TestCase;
use Yandex\Tests\Metrica\Fixtures\Delegates;

class DelegatesClientTest extends TestCase
{
    public function testGetDelegates()
    {
        $fixtures = Delegates::$delegatesFixtures;

        $mock = $this->getMock('Yandex\Metrica\Management\DelegatesClient', array('sendGetRequest'));
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getDelegates();

        $this->assertEquals($fixtures["delegates"][0]["user_login"], $table->current()->getUserLogin());
        $this->assertEquals($fixtures["delegates"][0]["created_at"], $table->current()->getCreatedAt());
        $this->assertEquals($fixtures["delegates"][0]["comment"], $table->current()->getComment());
    }
}
