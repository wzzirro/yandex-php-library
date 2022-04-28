<?php

namespace Yandex\Tests\Metrica\Fixtures;

class Operations
{
    public static $operationsFixtures = array(
        "operations" => array(
            0 => array(
                "id" => 66955,
                "action" => "cut_parameter",
                "attr" => "url",
                "value" => "debug",
                "status" => "active"
            ),
            1 => array(
                "id" => 66958,
                "action" => "merge_https_and_http",
                "attr" => "url",
                "value" => "",
                "status" => "active"
            )
        )
    );

    public static $operationFixtures = array(
        "operation" => array(
            "id" => 66955,
            "action" => "cut_parameter",
            "attr" => "url",
            "value" => "debug",
            "status" => "active"
        )
    );
}
