<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$arrayMenu = array(
	"name"=>"STS Links",
	"sort"=>121,
	"hidden"=>false,
	"items"=>array(
		array(
			"name"=>"SALG",
			"hidden"=>false,
			"attrs"=>array(
				"data-url"=> "/dashboard/index.php?SECTION_ID=16",
				"data-modern-style"=>"Y",
				"data-name"=>"SALG",
				"data-page-id"=>"dashboard_salg",
				"id"=>"dashboard_salg_id",
			),
		),
		array(
			"name"=>"EFTERMARKED",
			"hidden"=>false,
			"attrs"=>array(
				"data-url"=> "/dashboard/index.php?SECTION_ID=20",
				"data-modern-style"=>"Y",
				"data-name"=>"EFTERMARKED",
				"data-page-id"=>"dashboard_eftermarked",
				"id"=>"dashboard_eftermarked_id",
			)
		)
	)
);


$arResult["MENU"][] = $arrayMenu;
die();