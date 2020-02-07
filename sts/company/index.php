<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/intranet/public/company/index.php");
$APPLICATION->SetTitle(GetMessage("COMPANY_TITLE"));
?><?$APPLICATION->IncludeComponent(
	"make:intranet.search",
	"bitrix24",
	Array(
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_SHADOW" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"ALPHABET_LANG" => array("en",""),
		"CACHE_TIME" => "604800",
		"CACHE_TYPE" => "A",
		"DATE_FORMAT" => "d.m.Y",
		"DATE_FORMAT_NO_YEAR" => "d.m",
		"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
		"DEFAULT_VIEW" => "list",
		"EXTRANET_TYPE" => "",
		"FILTER_1C_USERS" => "N",
		"FILTER_DEPARTMENT_SINGLE" => "N",
		"FILTER_NAME" => "company_search",
		"FILTER_SECTION_CURONLY" => "N",
		"FILTER_SESSION" => "Y",
		"LIST_VIEW" => "list",
		"NAME_TEMPLATE" => "",
		"NAV_TITLE" => GetMessage("COMPANY_NAV_TITLE"),
		"PATH_TO_CONPANY_DEPARTMENT" => "/sts/company/structure.php?set_filter_structure=Y&structure_UF_DEPARTMENT=#ID#",
		"PATH_TO_USER_EDIT" => "/company/personal/user/#user_id#/edit/",
		"PATH_TO_VIDEO_CALL" => "/sts/company/personal/video/#USER_ID#/",
		"PM_URL" => "/sts/company/personal/messages/chat/#USER_ID#/",
		"SHOW_DEP_HEAD_ADDITIONAL" => "N",
		"SHOW_ERROR_ON_NULL" => "Y",
		"SHOW_LOGIN" => "Y",
		"SHOW_NAV_BOTTOM" => "Y",
		"SHOW_NAV_TOP" => "N",
		"SHOW_UNFILTERED_LIST" => "Y",
		"SHOW_YEAR" => "Y",
		"STRUCTURE_FILTER" => "structure",
		"STRUCTURE_PAGE" => "structure.php",
		"TABLE_VIEW" => ".default",
		"USERS_PER_PAGE" => "25",
		"USER_PROPERTY_EXCEL" => array("FULL_NAME","EMAIL","PERSONAL_PHONE","PERSONAL_FAX","PERSONAL_MOBILE","WORK_POSITION","UF_DEPARTMENT","UF_PHONE_INNER","UF_SKYPE"),
		"USER_PROPERTY_LIST" => array("PERSONAL_PHOTO","EMAIL","PERSONAL_PHONE","PERSONAL_FAX","PERSONAL_MOBILE","UF_DEPARTMENT","UF_PHONE_INNER","UF_SKYPE"),
		"USER_PROPERTY_TABLE" => array("PERSONAL_PHOTO","FULL_NAME","WORK_POSITION","WORK_PHONE","UF_DEPARTMENT","UF_PHONE_INNER","UF_SKYPE"),
		"USE_VIEW_SELECTOR" => "Y"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>