<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$menuStructure[] = [
	"title" => "DDB",
	"hidden" => false,
	"sort" => $menuSort++,
	"items" => [
		[
			"title" => "Værksted DDB",
			"useLetterImage" => true,
			"color" => "#ed1c24",
			"params" => [
				"url" => "/ddb/vrk/index.php"
			],
			"id" => "custom_ddb1",
        ],
        [
			"title" => "Salg DDB",
			"useLetterImage" => true,
			"color" => "#1e3f5e",
			"params" => [
				"url" => "/ddb/salg/index.php"
			],
			"id" => "custom_ddb2",
        ],
        [
			"title" => "CarPlanner DDB",
			"useLetterImage" => true,
			"color" => "#8cd59f",
			"params" => [
				"url" => "/ddb/car/index.php"
			],
			"id" => "custom_ddb3",
        ],
        [
			"title" => "BizFone DDB",
			"useLetterImage" => true,
			"color" => "#5658fe",
			"params" => [
				"url" => "/ddb/biz/index.php"
			],
			"id" => "custom_ddb4",
        ],
        [
			"title" => "HFGD DDB",
			"useLetterImage" => true,
			"color" => "#459151",
			"params" => [
				"url" => "/mobile/ddb/hfgd/index.php"
			],
			"id" => "custom_ddb5",
        ],
        [
			"title" => "Fraværsregistrering DDB",
			"useLetterImage" => true,
			"color" => "#b1612a",
			"params" => [
				"url" => "/ddb/tm/index.php"
			],
			"id" => "custom_ddb6",
		],
	]
];

?>