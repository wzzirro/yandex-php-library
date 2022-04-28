<?php

namespace Yandex\Tests\Metrica;

use Yandex\Tests\TestCase;
use Yandex\Tests\Metrica\Fixtures\Grants;

class GrantsClientTest extends TestCase
{
    public function testGetGrants()
    {
        $fixtures = Grants::$grantsFixtures;

        $mock = $this->getMock('Yandex\Metrica\Management\GrantsClient', array('sendGetRequest'));
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getGrants(2215573);

        $this->assertEquals($fixtures["grants"][0]["user_login"], $table->current()->getUserLogin());
        $this->assertEquals($fixtures["grants"][0]["perm"], $table->current()->getPerm());
        $this->assertEquals($fixtures["grants"][0]["created_at"], $table->current()->getCreatedAt());
        $this->assertEquals($fixtures["grants"][0]["comment"], $table->current()->getComment());
        $this->assertEquals($fixtures["grants"][1]["user_login"], $table->next()->getUserLogin());
        $this->assertEquals($fixtures["grants"][1]["perm"], $table->current()->getPerm());
        $this->assertEquals($fixtures["grants"][1]["created_at"], $table->current()->getCreatedAt());
        $this->assertEquals($fixtures["grants"][1]["comment"], $table->current()->getComment());
    }

    public function testGetGrant()
    {
        $fixtures = Grants::$grantFixtures;

        $mock = $this->getMock('Yandex\Metrica\Management\GrantsClient', array('sendGetRequest'));
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getGrant(2215573, "api-metrika2");

        $this->assertEquals($fixtures["grant"]["user_login"], $table->getUserLogin());
        $this->assertEquals($fixtures["grant"]["perm"], $table->getPerm());
        $this->assertEquals($fixtures["grant"]["created_at"], $table->getCreatedAt());
        $this->assertEquals($fixtures["grant"]["comment"], $table->getComment());
    }
}
