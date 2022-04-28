<?php

namespace Yandex\Tests\Metrica;

use Yandex\Tests\TestCase;
use Yandex\Tests\Metrica\Fixtures\Operations;

class OperationsClientTest extends TestCase
{
    public function testGetOperations()
    {
        $fixtures = Operations::$operationsFixtures;

        $mock = $this->getMock('Yandex\Metrica\Management\OperationsClient', array('sendGetRequest'));
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getOperations(2215573);

        $this->assertEquals($fixtures["operations"][0]["id"], $table->current()->getId());
        $this->assertEquals($fixtures["operations"][0]["action"], $table->current()->getAction());
        $this->assertEquals($fixtures["operations"][0]["attr"], $table->current()->getAttr());
        $this->assertEquals($fixtures["operations"][0]["value"], $table->current()->getValue());
        $this->assertEquals($fixtures["operations"][0]["status"], $table->current()->getStatus());
        $this->assertEquals($fixtures["operations"][1]["id"], $table->next()->getId());
        $this->assertEquals($fixtures["operations"][1]["action"], $table->current()->getAction());
        $this->assertEquals($fixtures["operations"][1]["attr"], $table->current()->getAttr());
        $this->assertEquals($fixtures["operations"][1]["value"], $table->current()->getValue());
        $this->assertEquals($fixtures["operations"][1]["status"], $table->current()->getStatus());
    }

    public function testGetOperation()
    {
        $fixtures = Operations::$operationFixtures;

        $mock = $this->getMock('Yandex\Metrica\Management\OperationsClient', array('sendGetRequest'));
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getOperation(2215573, 66955);

        $this->assertEquals($fixtures["operation"]["id"], $table->getId());
        $this->assertEquals($fixtures["operation"]["action"], $table->getAction());
        $this->assertEquals($fixtures["operation"]["attr"], $table->getAttr());
        $this->assertEquals($fixtures["operation"]["value"], $table->getValue());
        $this->assertEquals($fixtures["operation"]["status"], $table->getStatus());
    }
}
