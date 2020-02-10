<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$arItems = [];

if(array_intersect($getGroups, array(66))) 
{
	array_push($arItems, [
		"title" => "Værksted",
		"useLetterImage" => true,
		"color" => "#ed1c24",
		"params" => [
			"url" => "/sts/ddb/vrk/index.php"
		],
		"id" => "custom_ddb1",
	]);
}

if(array_intersect($getGroups, array(99))) 
{
	array_push($arItems, [
		"title" => "Salg",
		"useLetterImage" => true,
		"color" => "#1e3f5e",
		"params" => [
			"url" => "/sts/ddb/salg/index.php"
		],
		"id" => "custom_ddb2",
	]);
}

if(array_intersect($getGroups, array(37))) 
{
	array_push($arItems, [
		"title" => "CarPlanner",
		"useLetterImage" => true,
		"color" => "#8cd59f",
		"params" => [
			"url" => "/sts/ddb/car/index.php"
		],
		"id" => "custom_ddb3",
	]);
}

if(array_intersect($getGroups, array(36))) 
{
	array_push($arItems, [
		"title" => "BizFone",
		"useLetterImage" => true,
		"color" => "#5658fe",
		"params" => [
			"url" => "/sts/ddb/biz/index.php"
		],
		"id" => "custom_ddb4",
	]);
}

if(array_intersect($getGroups, array(35))) 
{
	array_push($arItems, [
		"title" => "HFGD",
		"useLetterImage" => true,
		"color" => "#459151",
		"params" => [
			"url" => "/sts/ddb/hfgd/index.php"
		],
		"id" => "custom_ddb5",
	]);
}

if(array_intersect($getGroups, array(110))) 
{
	array_push($arItems, [
		"title" => "Fraværsregistrering",
		"useLetterImage" => true,
		"color" => "#b1612a",
		"params" => [
			"url" => "/sts/ddb/tm/index.php"
		],
		"id" => "custom_ddb6",
	]);
}

if(!empty($arItems))
{
	$menuStructure[] = [
		"title" => "STS",
		"hidden" => false,
		"sort" => $menuSort++,
		"items" => $arItems
	];
}

?>