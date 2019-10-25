<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/intranet/public/company/telephones.php");

$APPLICATION->SetTitle(GetMessage("COMPANY_TITLE"));
?><?$APPLICATION->IncludeComponent("make:intranet.search", "sts-phonelist", array(
	"STRUCTURE_PAGE" => "structure.php",
	"PM_URL" => "/auto/company/personal/messages/chat/#USER_ID#/",
	"PATH_TO_CONPANY_DEPARTMENT" => "/auto/company/structure.php?set_filter_structure=Y&structure_UF_DEPARTMENT=#ID#",
	"STRUCTURE_FILTER" => "structure",
	"FILTER_1C_USERS" => "N",
	"USERS_PER_PAGE" => "700",
	"FILTER_SECTION_CURONLY" => "N",
	"NAME_TEMPLATE" => "",
	"SHOW_LOGIN" => "Y",
	"SHOW_ERROR_ON_NULL" => "Y",
	"ALPHABET_LANG" => array(
		0 => (LANGUAGE_ID == "en") ? "en" : ((LANGUAGE_ID == "de") ? "en" : "ru"),
		1 => "",
	),
	"NAV_TITLE" => GetMessage("COMPANY_NAV_TITLE"),
	"SHOW_NAV_TOP" => "N",
	"SHOW_NAV_BOTTOM" => "Y",
	"SHOW_UNFILTERED_LIST" => "Y",
	"AJAX_MODE" => "Y",
	"AJAX_OPTION_SHADOW" => "Y",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "Y",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600000",
	"DATE_FORMAT" => "F j, Y",
	"DATE_FORMAT_NO_YEAR" => "F j",
	"DATE_TIME_FORMAT" => "F j, Y h:i a",
	"SHOW_YEAR" => "Y",
	"PATH_TO_VIDEO_CALL" => "/auto/company/personal/video/#USER_ID#/",
	"FILTER_NAME" => "users",
	"FILTER_DEPARTMENT_SINGLE" => "Y",
	"FILTER_SESSION" => "N",
	"USE_VIEW_SELECTOR" => "N",
	"DEFAULT_VIEW" => "table",
	"LIST_VIEW" => "list",
	"TABLE_VIEW" => "group_table",
	"USER_PROPERTY_TABLE" => array(
		0 => "FULL_NAME",
		1 => "EMAIL",
		2 => "WORK_POSITION",
		3 => "WORK_PHONE",
		4 => "UF_PHONE_INNER",
		5 => "UF_SKYPE",
	),
	"USER_PROPERTY_EXCEL" => array(
		0 => "FULL_NAME",
		1 => "EMAIL",
		2 => "WORK_POSITION",
		3 => "WORK_PHONE",
		4 => "UF_DEPARTMENT",
		5 => "UF_PHONE_INNER",
		6 => "UF_SKYPE",
	),
	"USER_PROPERTY_LIST" => array(
		0 => "FULL_NAME",
		1 => "EMAIL",
		2 => "PERSONAL_MOBILE",
		3 => "WORK_PHONE",
		4 => "UF_SKYPE",
		5 => "PERSONAL_PHOTO",
	),
	"EXTRANET_TYPE" => "",
	"AJAX_OPTION_ADDITIONAL" => "",
	"DISPLAY_USER_PHOTO" => "N"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>