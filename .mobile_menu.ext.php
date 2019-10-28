<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$arItems = [];

if(array_intersect($getGroups, array(106))) 
{
	array_push($arItems, [
		"title" => "Værksted DDB",
		"useLetterImage" => true,
		"color" => "#ed1c24",
		"params" => [
			"url" => "/ddb/vrk/index.php"
		],
		"id" => "custom_ddb1",
	]);
}

if(array_intersect($getGroups, array(98))) 
{
	array_push($arItems, [
		"title" => "Salg DDB",
		"useLetterImage" => true,
		"color" => "#1e3f5e",
		"params" => [
			"url" => "/ddb/salg/index.php"
		],
		"id" => "custom_ddb2",
	]);
}

if(array_intersect($getGroups, array(108))) 
{
	array_push($arItems, [
		"title" => "CarPlanner DDB",
		"useLetterImage" => true,
		"color" => "#8cd59f",
		"params" => [
			"url" => "/ddb/car/index.php"
		],
		"id" => "custom_ddb3",
	]);
}

if(array_intersect($getGroups, array(107))) 
{
	array_push($arItems, [
		"title" => "BizFone DDB",
		"useLetterImage" => true,
		"color" => "#5658fe",
		"params" => [
			"url" => "/ddb/biz/index.php"
		],
		"id" => "custom_ddb4",
	]);
}

if(array_intersect($getGroups, array(32))) 
{
	array_push($arItems, [
		"title" => "HFGD DDB",
		"useLetterImage" => true,
		"color" => "#459151",
		"params" => [
			"url" => "/mobile/ddb/hfgd/index.php"
		],
		"id" => "custom_ddb5",
	]);
}

if(array_intersect($getGroups, array(109))) 
{
	array_push($arItems, [
		"title" => "Fraværsregistrering DDB",
		"useLetterImage" => true,
		"color" => "#b1612a",
		"params" => [
			"url" => "/ddb/tm/index.php"
		],
		"id" => "custom_ddb6",
	]);
}

if(!empty($arItems))
{
	$menuStructure[] = [
		"title" => "DDB",
		"hidden" => false,
		"sort" => $menuSort++,
		"items" => $arItems
	];
}


?>