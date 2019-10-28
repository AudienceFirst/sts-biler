<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$menuStructure[] = [
	"title" => "STS",
	"hidden" => false,
	"sort" => $menuSort++,
	"items" => [
		[
			"title" => "Værksted",
			"useLetterImage" => true,
			"color" => "#ed1c24",
			"params" => [
				"url" => "/sts/ddb/vrk/index.php"
			],
			"id" => "custom_ddb1",
        ],
        [
			"title" => "Salg",
			"useLetterImage" => true,
			"color" => "#1e3f5e",
			"params" => [
				"url" => "/sts/ddb/salg/index.php"
			],
			"id" => "custom_ddb2",
        ],
        [
			"title" => "CarPlanner",
			"useLetterImage" => true,
			"color" => "#8cd59f",
			"params" => [
				"url" => "/sts/ddb/car/index.php"
			],
			"id" => "custom_ddb3",
        ],
        [
			"title" => "BizFone",
			"useLetterImage" => true,
			"color" => "#5658fe",
			"params" => [
				"url" => "/sts/ddb/biz/index.php"
			],
			"id" => "custom_ddb4",
        ],
        [
			"title" => "HFGD",
			"useLetterImage" => true,
			"color" => "#459151",
			"params" => [
				"url" => "/sts/ddb/hfgd/index.php"
			],
			"id" => "custom_ddb5",
        ],
        [
			"title" => "Fraværsregistrering",
			"useLetterImage" => true,
			"color" => "#b1612a",
			"params" => [
				"url" => "/sts/ddb/tm/index.php"
			],
			"id" => "custom_ddb6",
		],
	]
];

?>