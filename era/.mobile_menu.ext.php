<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$menuStructure[] = [
	"title" => "ERA",
	"hidden" => false,
	"sort" => $menuSort++,
	"items" => [
		[
			"title" => "Værksted",
			"useLetterImage" => true,
			"color" => "#ed1c24",
			"params" => [
				"url" => "/era/ddb/vrk/index.php"
			],
			"id" => "custom_ddb1",
        ],
        [
			"title" => "Salg",
			"useLetterImage" => true,
			"color" => "#1e3f5e",
			"params" => [
				"url" => "/era/ddb/salg/index.php"
			],
			"id" => "custom_ddb2",
        ],
        [
			"title" => "CarPlanner",
			"useLetterImage" => true,
			"color" => "#8cd59f",
			"params" => [
				"url" => "/era/ddb/car/index.php"
			],
			"id" => "custom_ddb3",
        ],
        [
			"title" => "BizFone",
			"useLetterImage" => true,
			"color" => "#5658fe",
			"params" => [
				"url" => "/era/ddb/biz/index.php"
			],
			"id" => "custom_ddb4",
        ],
        [
			"title" => "HFGD",
			"useLetterImage" => true,
			"color" => "#459151",
			"params" => [
				"url" => "/era/ddb/hfgd/index.php"
			],
			"id" => "custom_ddb5",
        ],
        [
			"title" => "Fraværsregistrering",
			"useLetterImage" => true,
			"color" => "#b1612a",
			"params" => [
				"url" => "/era/ddb/tm/index.php"
			],
			"id" => "custom_ddb6",
		],
	]
];

?>