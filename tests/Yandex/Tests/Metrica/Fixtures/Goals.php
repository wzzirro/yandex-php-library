<?php

namespace Yandex\Tests\Metrica\Fixtures;

class Goals
{
    public static $goalsFixtures = array(
        "goals" => array(
            0 => array(
                "id" => 334420,
                "name" => "Хорошо просмотрел сайт",
                "type" => "number",
                "depth" => 8,
                "class" => 1
            ),
            1 => array(
                "id" => 334423,
                "name" => "Корзина",
                "type" => "url",
                "flag" => "basket",
                "conditions" => array(
                    0 => array(
                        "type" => "contain",
                        "url" => "/basket.php?add"
                    )
                ),
                "class" => 1
            )
        )
    );

    public static $goalFixtures = array(
        "goal" => array(
            "id" => 334423,
            "name" => "Корзина",
            "type" => "url",
            "flag" => "basket",
            "conditions" => array(
                0 => array(
                    "type" => "contain",
                    "url" => "/basket.php?add"
                )
            ),
            "class" => 1
        )
    );
}
