<?php

namespace Yandex\Tests\Metrica\Fixtures;

class Grants
{
    public static $grantsFixtures = array(
        "grants" => array(
            0 => array(
                "user_login" => "api-metrika2",
                "perm" => "view",
                "created_at" => "2010-12-08 20:02:01",
                "comment" => ""
            ),
            1 => array(
                "user_login" => "",
                "perm" => "public_stat",
                "created_at" => "2010-12-08 20:02:01",
                "comment" => ""
            )
        )
    );

    public static $grantFixtures = array(
        "grant" => array(
            "user_login" => "api-metrika2",
            "perm" => "view",
            "created_at" => "2010-12-08 20:02:01",
            "comment" => ""
        )
    );
}
