<?
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

Loc::loadMessages(__FILE__);

$APPLICATION->SetAdditionalCSS($this->getFolder()."/map.css");
$APPLICATION->SetAdditionalCSS($this->getFolder()."/groups.css");
$APPLICATION->AddHeadScript($this->getFolder()."/map.js");

if (!function_exists("recalculateCrmCounter"))
{
	function recalculateCrmCounter($counterId)
	{
		if (preg_match("~^crm_~i", $counterId) && \Bitrix\Main\Loader::includeModule("crm"))
		{
			\Bitrix\Crm\Counter\EntityCounterManager::prepareValue($counterId);
		}
	}
}

/*
 * CUserOptions::GetOption("intranet", "left_menu_self_items_s1") - array of self-added items (contains TEXT, LINK, ID)
 * CUserOptions::GetOption("intranet", "left_menu_sorted_items_s1") - 2-dimensional array of items id (show/hide)
 *
 * Delete permissions:
 * 	N - can't delete;
 * 	Y - can delete;
 * 	A - only admin can delete
 */
$defaultItems = $arResult;
$arResult = array();

$arResult["IS_ADMIN"] = "N";
if (
	IsModuleInstalled("bitrix24")
	&& $GLOBALS['USER']->CanDoOperation('bitrix24_config')
	|| !IsModuleInstalled("bitrix24")
	&& $GLOBALS['USER']->IsAdmin()
)
{
	$arResult["IS_ADMIN"] = "Y";
}

$arResult["IS_EXTRANET"] = isModuleInstalled("extranet") && SITE_ID == COption::GetOptionString("extranet", "extranet_site");

$arResult["SHOW_PRESET_POPUP"] = COption::GetOptionString("intranet", "show_menu_preset_popup", "N") == "Y";
if ($arResult["SHOW_PRESET_POPUP"])
{
	COption::SetOptionString("intranet", "show_menu_preset_popup", "N");
}

$newItems = array();
$mapItems = array();
$myToolsItems = array();

//default items
foreach ($defaultItems as $itemIndex => $item)
{
	if (!isset($item["PARAMS"]) || !is_array($item["PARAMS"]))
	{
		$item["PARAMS"] = array();
	}

	//id to item
	if (!isset($item["PARAMS"]["menu_item_id"]))
	{
		$item["PARAMS"]["menu_item_id"] = ($item["PARAMS"]["name"] == "live_feed") ? "menu_live_feed" : crc32($item["LINK"]);
	}

	if (isset($item["PARAMS"]["my_tools_section"]) && $item["PARAMS"]["my_tools_section"] === true)
	{
		$myToolsItems[] = $item;
		$myToolsItems[count($myToolsItems) - 1]["DEPTH_LEVEL"] = 2;

		//Skip empty root items
		if (
			$item["DEPTH_LEVEL"] !== 1 ||
			!isset($defaultItems[$itemIndex + 1]) ||
			$defaultItems[$itemIndex + 1]["DEPTH_LEVEL"] !== 1)
		{
			$mapItems[] = $item;
		}
	}
	else
	{
		$mapItems[] = $item;
	}

	if ($item["DEPTH_LEVEL"] !== 1 || (isset($item["PARAMS"]["hidden"]) && $item["PARAMS"]["hidden"] === true))
	{
		continue;
	}

	$item["ITEM_TYPE"] = "default";
	$item["DELETE_PERM"] = "N";

	if (isset($item["PARAMS"]["counter_id"]))
	{
		recalculateCrmCounter($item["PARAMS"]["counter_id"]);
	}

	$newItems[$item["PARAMS"]["menu_item_id"]] = $item;
}

if (!empty($myToolsItems))
{
	array_unshift($myToolsItems, array(
		"TEXT" => Loc::getMessage("MENU_MY_WORKSPACE"),
		"LINK" => SITE_DIR,
		"SELECTED" => false,
		"PERMISSION" => "X",
		"PARAMS" => array(
			"menu_item_item" => "my_instruments"
		),
		"DEPTH_LEVEL" => 1,
		"IS_PARENT" => true,
		"ADDITIONAL_LINKS" => array()
	));
}

$arResult["MAP_ITEMS"] = $arResult["IS_EXTRANET"] ? array() : array_merge($myToolsItems, $mapItems);

if (CUserOptions::GetOption("intranet", "left_menu_converted_".SITE_ID, "N") !== "Y")
{
	include($_SERVER["DOCUMENT_ROOT"].$this->GetFolder()."/convertor.php");
}

if (!$arResult["IS_EXTRANET"] && CUserOptions::GetOption("intranet", "left_menu_group_converted_".SITE_ID, "N") !== "Y")
{
	include($_SERVER["DOCUMENT_ROOT"].$this->GetFolder()."/group_converter.php");
}

//user standard items
$standardItems = CUserOptions::GetOption("intranet", "left_menu_standard_items_".SITE_ID);
if (is_array($standardItems) && !empty($standardItems))
{
	foreach ($standardItems as $item)
	{
		$counterId = isset($item["COUNTER_ID"]) ? $item["COUNTER_ID"] : "";
		$newItems[$item["ID"]] = array(
			"TEXT" => htmlspecialcharsbx($item["TEXT"]),
			"LINK" => htmlspecialcharsbx($item["LINK"]),
			"PERMISSION" => "X",
			"PARAMS" => array(
				"menu_item_id" => htmlspecialcharsbx($item["ID"]),
				"counter_id" => htmlspecialcharsbx($counterId)
			),
			"ITEM_TYPE" => "standard",
			"DELETE_PERM" => "Y"
		);

		if (isset($item["SUB_LINK"]) && !empty($item["SUB_LINK"]))
		{
			$newItems[$item["ID"]]["PARAMS"]["sub_link"] = $item["SUB_LINK"];
		}

		recalculateCrmCounter($counterId);
	}
}

//user self-added items
$userItems = CUserOptions::GetOption("intranet", "left_menu_self_items_".SITE_ID);
if (is_array($userItems) && !empty($userItems))
{
	foreach ($userItems as $item)
	{
		$newItems[$item["ID"]] = array(
			"TEXT" => htmlspecialcharsbx($item["TEXT"]),
			"LINK" => htmlspecialcharsbx($item["LINK"]),
			"PERMISSION" => "X",
			"PARAMS" => array(
				"menu_item_id" => htmlspecialcharsbx($item["ID"])
			),
			"ITEM_TYPE" => "self",
			"DELETE_PERM" => "Y",
			"OPEN_IN_NEW_PAGE" => isset($item["NEW_PAGE"]) && $item["NEW_PAGE"] == "Y" ? true : false
		);
	}
}

//admin items to all
$adminItems = COption::GetOptionString("intranet", "left_menu_items_to_all_".SITE_ID);
if (!empty($adminItems))
{
	$adminItems = unserialize($adminItems);
	foreach ($adminItems as $item)
	{
		$counterId = isset($item["COUNTER_ID"]) ? $item["COUNTER_ID"] : "";
		$newItems[$item["ID"]] = array(
			"TEXT" => htmlspecialcharsbx($item["TEXT"]),
			"LINK" => htmlspecialcharsbx($item["LINK"]),
			"PERMISSION" => "X",
			"PARAMS" => array(
				"menu_item_id" => htmlspecialcharsbx($item["ID"]),
				"counter_id" => htmlspecialcharsbx($counterId)
			),
			"ITEM_TYPE" => ($arResult["IS_ADMIN"] && isset($newItems[$item["ID"]])) ? $newItems[$item["ID"]]["ITEM_TYPE"] : "admin",
			"DELETE_PERM" => "A",
			"OPEN_IN_NEW_PAGE" => isset($item["NEW_PAGE"]) && $item["NEW_PAGE"] == "Y" ? true : false
		);

		if(array_key_exists('ADDITIONAL_LINKS', $item) && is_array($item['ADDITIONAL_LINKS']) && count($item['ADDITIONAL_LINKS']) > 0)
		{
			$newItems[$item["ID"]]['ADDITIONAL_LINKS'] = $item['ADDITIONAL_LINKS'];
		}

		recalculateCrmCounter($counterId);
	}
}

//sorted items
$sortedItems = array();
$arResult["ITEMS"]["show"] = array();

$presets = array(
	"social" => array(
		"show" => array(
			"menu_live_feed",
			"menu_tasks",
			"menu_im_messenger",
			"menu_all_groups",
			"menu_files",
			"menu_calendar",
			"menu_external_mail",
			"menu_contact_center",
			"menu_crm_favorite",
			"menu_sites",
			"menu_timeman_sect",
			"menu_company",
		),
		"hide" => array(
			"menu_marketing",
			"menu_shop",
			"menu_openlines",
			"menu_telephony",
			"menu_ai",
			"menu_onec_sect",
			"menu_marketplace_sect",
			"menu_bizproc_sect",
			"menu_tariff",
			"menu_updates",
			"menu_configs_sect",
		)
	),
	"crm" => array(
		"show" => array(
			"menu_crm_favorite",
			"menu_marketing",
			"menu_tasks",
			"menu_external_mail",
			"menu_shop",
			"menu_sites",
			"menu_contact_center",
		),
		"hide" => array(
			"menu_company",
			"menu_files",
			"menu_calendar",
			"menu_im_messenger",
			"menu_all_groups",
			"menu_ai",
			"menu_onec_sect",
			"menu_marketplace_sect",
			"menu_timeman_sect",
			"menu_live_feed",
			"menu_telephony",
			"menu_openlines",
			"menu_bizproc_sect",
			"menu_updates",
			"menu_tariff",
			"menu_configs_sect",
		)
	),
	"tasks" => array(
		"show" => array(
			"menu_tasks",
			"menu_calendar",
			"menu_files",
			"menu_im_messenger",
			"menu_external_mail",
			"menu_crm_favorite",
			"menu_company",
		),
		"hide" => array(
			"menu_live_feed",
			"menu_all_groups",
			"menu_timeman_sect",
			"menu_sites",
			"menu_shop",
			"menu_contact_center",
			"menu_marketing",
			"menu_openlines",
			"menu_telephony",
			"menu_ai",
			"menu_onec_sect",
			"menu_marketplace_sect",
			"menu_bizproc_sect",
			"menu_tariff",
			"menu_updates",
			"menu_configs_sect",
		)
	),
	"sites" => array(
		"show" => array(
			"menu_sites",
			"menu_shop",
			"menu_contact_center",
			"menu_external_mail",
			"menu_crm_favorite",
			"menu_marketing",
			"menu_tasks",
		),
		"hide" => array(
			"menu_live_feed",
			"menu_im_messenger",
			"menu_calendar",
			"menu_files",
			"menu_timeman_sect",
			"menu_all_groups",
			"menu_openlines",
			"menu_telephony",
			"menu_company",
			"menu_ai",
			"menu_onec_sect",
			"menu_marketplace_sect",
			"menu_bizproc_sect",
			"menu_tariff",
			"menu_updates",
			"menu_configs_sect",
		)
	),
	"shop" => array(
		"show" => array(
			"menu_shop",
			"menu_crm_favorite",
			"menu_marketing",
			"menu_contact_center",
			"menu_external_mail",
			"menu_sites",
			"menu_tasks",
		),
		"hide" => array(
			"menu_live_feed",
			"menu_im_messenger",
			"menu_calendar",
			"menu_files",
			"menu_timeman_sect",
			"menu_all_groups",
			"menu_openlines",
			"menu_telephony",
			"menu_company",
			"menu_ai",
			"menu_onec_sect",
			"menu_marketplace_sect",
			"menu_bizproc_sect",
			"menu_tariff",
			"menu_updates",
			"menu_configs_sect",
		)
	)
);

$arResult["IS_CUSTOM_PRESET_AVAILABLE"] = true;
if (\Bitrix\Main\Loader::includeModule("bitrix24"))
{
	if (!(CBitrix24::IsLicensePaid() || CBitrix24::IsDemoLicense() || CBitrix24::IsNfrLicense()))
	{
		$arResult["IS_CUSTOM_PRESET_AVAILABLE"] = false;
	}
}

$arResult["CUSTOM_PRESET_EXISTS"] = COption::GetOptionString("intranet", "left_menu_custom_preset_sort", "") ? true : false;
$arResult["CURRENT_PRESET_ID"] = "social";
//personal
$presetId = CUserOptions::GetOption("intranet", "left_menu_preset");
if ($presetId)
{
	CUserOptions::SetOption("intranet", "left_menu_preset_".SITE_ID, $presetId);
	CUserOptions::DeleteOption("intranet", "left_menu_preset", false, $USER->GetID());
}
$presetId = CUserOptions::GetOption("intranet", "left_menu_preset_".SITE_ID);

//global
if (!in_array($presetId, array("social", "tasks", "crm", "sites", "custom")))
{
	$presetId = COption::GetOptionString("intranet", "left_menu_preset", "");
}
if ($presetId == "custom")
{
	$customItems = COption::GetOptionString("intranet", "left_menu_custom_preset_items", "");
	if ($customItems)
	{
		$customItems= unserialize($customItems);
		foreach ($customItems as $item)
		{
			$newItems[$item["ID"]] = array(
				"TEXT" => htmlspecialcharsbx($item["TEXT"]),
				"LINK" => htmlspecialcharsbx($item["LINK"]),
				"PERMISSION" => "X",
				"PARAMS" => array(
					"menu_item_id" => htmlspecialcharsbx($item["ID"]),
					"counter_id" => htmlspecialcharsbx($counterId)
				),
				"ITEM_TYPE" => "custom",
				"DELETE_PERM" => "A",
				"OPEN_IN_NEW_PAGE" => isset($item["NEW_PAGE"]) && $item["NEW_PAGE"] == "Y" ? true : false
			);
		}
	}
}

$sortedItemsId = CUserOptions::GetOption("intranet", "left_menu_sorted_items_".SITE_ID);
if (!is_array($sortedItemsId) || empty($sortedItemsId))
{
	if (in_array($presetId, array("social", "tasks", "crm", "sites")))
	{
		$arResult["CURRENT_PRESET_ID"] = $presetId;
		$sortedItemsId = $presets[$presetId];
	}
	elseif ($arResult["IS_CUSTOM_PRESET_AVAILABLE"] && $presetId == "custom")
	{
		$arResult["CURRENT_PRESET_ID"] = $presetId;
		$sortedItemsId = COption::GetOptionString("intranet", "left_menu_custom_preset_sort", "");
		if ($sortedItemsId)
		{
			$sortedItemsId = unserialize($sortedItemsId);
		}
	}
	else
	{
		$sortedItemsId = $presets["social"];
	}
}

foreach (array("show", "hide") as $status)
{
	if (!(isset($sortedItemsId[$status]) && is_array($sortedItemsId[$status]) && !empty($sortedItemsId[$status])))
		continue;

	foreach ($sortedItemsId[$status] as $itemId)
	{
		if (!isset($newItems[$itemId]))
			continue;

		$arResult["ITEMS"][$status][] = $newItems[$itemId];
		unset($newItems[$itemId]);
	}
}

//add unsorted items to the end
if (!empty($newItems))
{
	$arResult["ITEMS"]["show"] = array_merge($arResult["ITEMS"]["show"], $newItems);
}

$counters = \CUserCounter::GetValues($USER->GetID(), SITE_ID);
$arResult["COUNTERS"] = is_array($counters) ? $counters : array();

$arResult["GROUPS"] = array();
if (!$arResult["IS_EXTRANET"] && $GLOBALS["USER"]->isAuthorized())
{
	$userId = $GLOBALS["USER"]->getId();
	$cacheTtl = defined("BX_COMP_MANAGED_CACHE") ? 2592000 : 600;
	$cacheId = "bitrix24_group_list_".$userId."_".SITE_ID."_".isModuleInstalled("extranet");
	$cacheDir = "/bx/bitrix24_group_list/".$userId;
	$cache = new CPHPCache;

	if ($cache->initCache($cacheTtl, $cacheId, $cacheDir))
	{
		$arResult["GROUPS"] = $cache->getVars();
	}
	else
	{
		$cache->startDataCache();

		if (defined("BX_COMP_MANAGED_CACHE"))
		{
			$GLOBALS["CACHE_MANAGER"]->startTagCache($cacheDir);
			$GLOBALS["CACHE_MANAGER"]->registerTag("sonet_user2group_U".$userId);
			$GLOBALS["CACHE_MANAGER"]->registerTag("sonet_group");
			$GLOBALS["CACHE_MANAGER"]->registerTag("sonet_group_favorites_U".$userId);
			$GLOBALS["CACHE_MANAGER"]->endTagCache();
		}

		$arResult["GROUPS"] = include($_SERVER["DOCUMENT_ROOT"].$this->getFolder()."/groups.php");
		$cache->endDataCache($arResult["GROUPS"]);
	}
}

$arResult["IS_PUBLIC_CONVERTED"] = file_exists($_SERVER["DOCUMENT_ROOT"].SITE_DIR."stream/");

//license button
if (CModule::IncludeModule('bitrix24') && in_array(CBitrix24::getLicenseType(), array("project", "demo")))
{
	$arResult["SHOW_LICENSE_BUTTON"] = false;
	if (
		!in_array(LANGUAGE_ID, array("ru", "ua"))
		|| (
			in_array(LANGUAGE_ID, array("ru", "ua")) &&
			(COption::GetOptionString("main", "~controller_date_create", "") + 86400 < time() || !intval(COption::GetOptionString("main", "~controller_date_create", "")))
		)
	)
	{
		$arResult["SHOW_LICENSE_BUTTON"] = true;
		$arResult["B24_LICENSE_PATH"] = CBitrix24::PATH_LICENSE_ALL;
		$arResult["LICENSE_BUTTON_COUNTER_URL"] = CBitrix24::PATH_COUNTER;
		$arResult["HOST_NAME"] = BX24_HOST_NAME;
	}
}


global $USER;
// if ($USER->GetID() == 10) {
//     echo '<pre>arResult is ';
//     print_r($arResult);
//     echo '</pre>';
//     exit();
// }

$i = 0;
$menuSort = [];
foreach ($arResult['SHOW'] as $key => $menuArray) {
    
    if ('menu_dimser_list' == $key) {
        continue;
    }

    if ($i == 1) {
        $menuSort[] = [
            'TEXT' => 'Dimser',
            'LINK' => '/ddb/',
            'SELECTED' => '',
            'PERMISSION' => 'X',
            'ADDITIONAL_LINKS' => [],
            'ITEM_TYPE' => 'default',
            'ITEM_INDEX' => 1,
            'PARAMS' => [
                'name' => 'dimser_list',
                'counter_id' => 'dimser-list',
                'menu_item_id' => 'menu_dimser_list',
                'my_tools_section' => '',
            ],
            'CHAIN' => ['Dimser'],
            'DEPTH_LEVEL' => 1,
            'IS_PARENT' => '',
            'DELETE_PERM' => 'N',
        ];
        $i++;
    }

    $menuSort[$i] = $menuArray;

    $i++;
}

$arResult['SHOW'] = $menuSort;
