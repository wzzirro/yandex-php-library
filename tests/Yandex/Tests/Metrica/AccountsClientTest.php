<?php

namespace Yandex\Tests\Metrica;

use Yandex\Tests\TestCase;
use Yandex\Tests\Metrica\Fixtures\Accounts;

class AccountsClientTest extends TestCase
{

    public function testGetAccounts()
    {
        $fixtures = Accounts::$accountsFixtures;

        $mock = $this->getMock('Yandex\Metrica\Management\AccountsClient', array('sendGetRequest'));
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getAccounts();

        $this->assertEquals($fixtures["accounts"][0]["user_login"], $table->current()->getUserLogin());
        $this->assertEquals($fixtures["accounts"][0]["created_at"], $table->current()->getCreatedAt());
    }
}
