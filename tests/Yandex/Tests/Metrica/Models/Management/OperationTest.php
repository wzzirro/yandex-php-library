<?php
namespace Yandex\Tests\Metrica\Models\Management;

use Yandex\Tests\Metrica\Fixtures\Operations;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Management\Models;

class OperationTest extends TestCase
{
    
    public function testGet()
    {
        $fixtures = Operations::$operationFixtures;
        
        $operation = new Models\Operation();
        $operation
            ->setId($fixtures['operation']['id'])
            ->setAction($fixtures['operation']['action'])
            ->setAttr($fixtures['operation']['attr'])
            ->setValue($fixtures['operation']['value'])
            ->setStatus($fixtures['operation']['status']);

        $this->assertEquals($fixtures["operation"]["id"], $operation->getId());
        $this->assertEquals($fixtures["operation"]["action"], $operation->getAction());
        $this->assertEquals($fixtures["operation"]["attr"], $operation->getAttr());
        $this->assertEquals($fixtures["operation"]["value"], $operation->getValue());
        $this->assertEquals($fixtures["operation"]["status"], $operation->getStatus());
    }
}
 