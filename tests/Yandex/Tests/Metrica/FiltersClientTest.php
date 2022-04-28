<?php

namespace Yandex\Tests\Metrica;

use Yandex\Tests\TestCase;
use Yandex\Tests\Metrica\Fixtures\Filters;

class FiltersClientTest extends TestCase
{

    public function testGetFilters()
    {
        $fixtures = Filters::$filtersFixtures;

        $mock = $this->getMock('Yandex\Metrica\Management\FiltersClient', array('sendGetRequest'));
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getFilters(2215573);

        $this->assertEquals($fixtures["filters"][0]["id"], $table->current()->getId());
        $this->assertEquals($fixtures["filters"][0]["attr"], $table->current()->getAttr());
        $this->assertEquals($fixtures["filters"][0]["type"], $table->current()->getType());
        $this->assertEquals($fixtures["filters"][0]["value"], $table->current()->getValue());
        $this->assertEquals($fixtures["filters"][0]["action"], $table->current()->getAction());
        $this->assertEquals($fixtures["filters"][0]["status"], $table->current()->getStatus());
        $this->assertEquals($fixtures["filters"][1]["id"], $table->next()->getId());
        $this->assertEquals($fixtures["filters"][1]["attr"], $table->current()->getAttr());
        $this->assertEquals($fixtures["filters"][1]["type"], $table->current()->getType());
        $this->assertEquals($fixtures["filters"][1]["value"], $table->current()->getValue());
        $this->assertEquals($fixtures["filters"][1]["action"], $table->current()->getAction());
        $this->assertEquals($fixtures["filters"][1]["status"], $table->current()->getStatus());
    }

    public function testGetFilter()
    {
        $fixtures = Filters::$filterFixtures;

        $mock = $this->getMock('Yandex\Metrica\Management\FiltersClient', array('sendGetRequest'));
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getFilter(2215573, 66943);

        $this->assertEquals($fixtures["filter"]["id"], $table->getId());
        $this->assertEquals($fixtures["filter"]["attr"], $table->getAttr());
        $this->assertEquals($fixtures["filter"]["type"], $table->getType());
        $this->assertEquals($fixtures["filter"]["value"], $table->getValue());
        $this->assertEquals($fixtures["filter"]["action"], $table->getAction());
        $this->assertEquals($fixtures["filter"]["status"], $table->getStatus());
        $this->assertEquals($fixtures["filter"]["start_ip"], $table->getStartIp());
        $this->assertEquals($fixtures["filter"]["end_ip"], $table->getEndIp());
    }
}
