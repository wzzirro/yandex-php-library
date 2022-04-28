<?php

namespace Yandex\Tests\Metrica;

use Yandex\Tests\TestCase;
use Yandex\Tests\Metrica\Fixtures\Goals;

class GoalsClientTest extends TestCase
{
    public function testGetGoals()
    {
        $fixtures = Goals::$goalsFixtures;

        $mock = $this->getMock('Yandex\Metrica\Management\GoalsClient', array('sendGetRequest'));
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getGoals(2215573);

        $this->assertEquals($fixtures["goals"][0]["id"], $table->current()->getId());
        $this->assertEquals($fixtures["goals"][0]["name"], $table->current()->getName());
        $this->assertEquals($fixtures["goals"][0]["type"], $table->current()->getType());
        $this->assertEquals($fixtures["goals"][0]["class"], $table->current()->getClass());
        $this->assertEquals($fixtures["goals"][1]["id"], $table->next()->getId());
        $this->assertEquals($fixtures["goals"][1]["name"], $table->current()->getName());
        $this->assertEquals($fixtures["goals"][1]["type"], $table->current()->getType());
        $this->assertEquals($fixtures["goals"][1]["flag"], $table->current()->getFlag());
        $this->assertEquals($fixtures["goals"][1]["class"], $table->current()->getClass());

        $conditions = $table->current()->getConditions();

        $this->assertEquals($fixtures["goals"][1]["conditions"][0]["type"], $conditions->current()->getType());
        $this->assertEquals($fixtures["goals"][1]["conditions"][0]["url"], $conditions->current()->getUrl());


    }

    public function testGetGoal()
    {
        $fixtures = Goals::$goalFixtures;

        $mock = $this->getMock('Yandex\Metrica\Management\GoalsClient', array('sendGetRequest'));
        $mock->expects($this->any())
            ->method('sendGetRequest')
            ->will($this->returnValue($fixtures));

        $table = $mock->getGoal(2215573, 334423);
        $conditions = $table->getConditions();

        $this->assertEquals($fixtures["goal"]["id"], $table->getId());
        $this->assertEquals($fixtures["goal"]["name"], $table->getName());
        $this->assertEquals($fixtures["goal"]["type"], $table->getType());
        $this->assertEquals($fixtures["goal"]["flag"], $table->getFlag());
        $this->assertEquals($fixtures["goal"]["class"], $table->getClass());
        $this->assertEquals($fixtures["goal"]["conditions"][0]["type"], $conditions->current()->getType());
        $this->assertEquals($fixtures["goal"]["conditions"][0]["url"], $conditions->current()->getUrl());
    }
}
