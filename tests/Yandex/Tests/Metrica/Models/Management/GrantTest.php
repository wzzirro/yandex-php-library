<?php
namespace Yandex\Tests\Metrica\Models\Management;

use Yandex\Tests\Metrica\Fixtures\Grants;
use Yandex\Tests\TestCase;
use Yandex\Metrica\Management\Models;

class GrantTest extends TestCase
{

    public function testGet()
    {
        $fixtures = Grants::$grantFixtures;
        
        $grant = new Models\Grant();
        $grant
            ->setComment($fixtures['grant']['comment'])
            ->setCreatedAt($fixtures['grant']['created_at'])
            ->setPerm($fixtures['grant']['perm'])
            ->setUserLogin($fixtures['grant']['user_login']);

        $this->assertEquals($fixtures["grant"]["user_login"], $grant->getUserLogin());
        $this->assertEquals($fixtures["grant"]["perm"], $grant->getPerm());
        $this->assertEquals($fixtures["grant"]["created_at"], $grant->getCreatedAt());
        $this->assertEquals($fixtures["grant"]["comment"], $grant->getComment());
    }
}
 