<?php

namespace Yandex\Tests\Metrica\Fixtures;

class Analytics
{
    public static $analyticsFixtures = array(
        "kind" => "analytics#gaData",
        "id" => "https://api-metrika.yandex.ru/analytics/v3/data/ga",
        "selfLink" => "https://api-metrika.yandex.ru/analytics/v3/data/ga",
        "containsSampledData" => false,
        "sampleSize" => "7617",
        "sampleSpace" => "7617",
        "query" => array(
            "ids" => "ga:2138128",
            "dimensions" => array ("ga:country"),
            "metrics" => array("ga:pageviews"),
            "sort" => array(),
            "start-date" => "2014-07-26",
            "end-date" => "2014-07-28",
            "start-index" => 1,
            "max-results" => 1000
        ),
        "itemsPerPage" => 1000,
        "totalResults" => 50,
        "columnHeaders" => array(
            0 => array(
                "name" => "ga:country",
                "columnType" => "DIMENSION",
                "dataType" => "STRING"
            ),
            1 => array(
                "name" => "ga:pageviews",
                "columnType" => "METRIC",
                "dataType" => "INTEGER"
            )
        ),
        "totalsForAllResults" => array(
            "ga:pageviews" => "13229"
        ),
        "rows" => array(
            array(
                "Russia",
                "11112"
            ),
            array(
                "Ukraine",
                "1132"
            ),
            array(
                "Belarus",
                "270"
            ),
            array(
                "Kazakhstan",
                "124"
            ),
            array(
                "Uzbekistan",
                "104"
            ),
            array(
                "Thailand",
                "76"
            )
        )
    );
}
