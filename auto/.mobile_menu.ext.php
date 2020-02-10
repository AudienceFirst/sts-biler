<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$arItems = [];

if(array_intersect($getGroups, array(97))) 
{
	array_push($arItems, [
		"title" => "Værksted",
		"useLetterImage" => true,
		"color" => "#ed1c24",
		"params" => [
			"url" => "/auto/ddb/vrk/index.php"
		],
		"id" => "custom_ddb1",
	]);
}

if(array_intersect($getGroups, array(105))) 
{
	array_push($arItems, [
		"title" => "Salg",
		"useLetterImage" => true,
		"color" => "#1e3f5e",
		"params" => [
			"url" => "/auto/ddb/salg/index.php"
		],
		"id" => "custom_ddb2",
	]);
}

if(array_intersect($getGroups, array(93))) 
{
	array_push($arItems, [
		"title" => "CarPlanner",
		"useLetterImage" => true,
		"color" => "#8cd59f",
		"params" => [
			"url" => "/auto/ddb/car/index.php"
		],
		"id" => "custom_ddb3",
	]);
}

if(array_intersect($getGroups, array(92))) 
{
	array_push($arItems, [
		"title" => "BizFone",
		"useLetterImage" => true,
		"color" => "#5658fe",
		"params" => [
			"url" => "/auto/ddb/biz/index.php"
		],
		"id" => "custom_ddb4",
	]);
}

if(array_intersect($getGroups, array(53))) 
{
	array_push($arItems, [
		"title" => "HFGD",
		"useLetterImage" => true,
		"color" => "#459151",
		"params" => [
			"url" => "/auto/ddb/hfgd/index.php"
		],
		"id" => "custom_ddb5",
	]);
}

if(array_intersect($getGroups, array(115))) 
{
	array_push($arItems, [
		"title" => "Fraværsregistrering",
		"useLetterImage" => true,
		"color" => "#b1612a",
		"params" => [
			"url" => "/auto/ddb/tm/index.php"
		],
		"id" => "custom_ddb6",
	]);
}

if(!empty($arItems))
{
	$menuStructure[] = [
		"title" => "AUTO",
		"hidden" => false,
		"sort" => $menuSort++,
		"items" => $arItems
	];
}

?>