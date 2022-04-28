<?php
namespace Yandex\Tests\Metrica\Models\Management;

use Yandex\Tests\Metrica\Fixtures\Filters;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Management\Models;

class FilterTest extends TestCase
{

    public function testGet()
    {
        $fixtures = Filters::$filterFixtures;

        $filter = new Models\Filter();
        $filter->setId($fixtures['filter']['id'])
            ->setAttr($fixtures['filter']['attr'])
            ->setType($fixtures['filter']['type'])
            ->setValue($fixtures['filter']['value'])
            ->setAction($fixtures['filter']['action'])
            ->setStatus($fixtures['filter']['status'])
            ->setStartIp($fixtures['filter']['start_ip'])
            ->setEndIp($fixtures['filter']['end_ip']);

        $this->assertEquals($fixtures["filter"]["id"], $filter->getId());
        $this->assertEquals($fixtures["filter"]["attr"], $filter->getAttr());
        $this->assertEquals($fixtures["filter"]["type"], $filter->getType());
        $this->assertEquals($fixtures["filter"]["value"], $filter->getValue());
        $this->assertEquals($fixtures["filter"]["action"], $filter->getAction());
        $this->assertEquals($fixtures["filter"]["status"], $filter->getStatus());
        $this->assertEquals($fixtures["filter"]["start_ip"], $filter->getStartIp());
        $this->assertEquals($fixtures["filter"]["end_ip"], $filter->getEndIp());
    }
}
 