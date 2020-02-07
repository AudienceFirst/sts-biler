<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/intranet/public/company/index.php");
$APPLICATION->SetTitle(GetMessage("COMPANY_TITLE"));
?>

<?$APPLICATION->IncludeComponent(
	"make:intranet.search", 
	"bitrix24", 
	array(
		"STRUCTURE_PAGE" => "structure.php",
		"PM_URL" => "/company/personal/messages/chat/#USER_ID#/",
		"PATH_TO_CONPANY_DEPARTMENT" => "/company/structure.php?set_filter_structure=Y&structure_UF_DEPARTMENT=#ID#",
		"PATH_TO_VIDEO_CALL" => "/company/personal/video/#USER_ID#/",
		"STRUCTURE_FILTER" => "structure",
		"FILTER_1C_USERS" => "N",
		"USERS_PER_PAGE" => "25",
		"FILTER_SECTION_CURONLY" => "N",
		"SHOW_ERROR_ON_NULL" => "Y",
		"NAV_TITLE" => GetMessage("COMPANY_NAV_TITLE"),
		"SHOW_NAV_TOP" => "N",
		"SHOW_NAV_BOTTOM" => "Y",
		"SHOW_UNFILTERED_LIST" => "Y",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_SHADOW" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "Y",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "604800",
		"FILTER_NAME" => "company_search",
		"FILTER_DEPARTMENT_SINGLE" => "Y",
		"FILTER_SESSION" => "N",
		"DEFAULT_VIEW" => "list",
		"LIST_VIEW" => "list",
		"USER_PROPERTY_TABLE" => array(
			0 => "PERSONAL_PHOTO",
			1 => "FULL_NAME",
			2 => "WORK_POSITION",
			3 => "WORK_PHONE",
			4 => "UF_DEPARTMENT",
			5 => "UF_PHONE_INNER",
			6 => "UF_SKYPE",
		),
		"USER_PROPERTY_EXCEL" => array(
			0 => "FULL_NAME",
			1 => "EMAIL",
			2 => "PERSONAL_PHONE",
			3 => "PERSONAL_FAX",
			4 => "PERSONAL_MOBILE",
			5 => "WORK_POSITION",
			6 => "UF_DEPARTMENT",
			7 => "UF_PHONE_INNER",
			8 => "UF_SKYPE",
		),
		"USER_PROPERTY_LIST" => array(
			0 => "PERSONAL_PHOTO",
			1 => "EMAIL",
			2 => "PERSONAL_PHONE",
			3 => "PERSONAL_FAX",
			4 => "PERSONAL_MOBILE",
			5 => "UF_DEPARTMENT",
			6 => "UF_PHONE_INNER",
			7 => "UF_SKYPE",
		),
		"COMPONENT_TEMPLATE" => "bitrix24",
		"PATH_TO_USER_EDIT" => "/company/personal/user/#user_id#/edit/",
		"NAME_TEMPLATE" => "",
		"SHOW_LOGIN" => "Y",
		"ALPHABET_LANG" => array(
			0 => "da",
			1 => "",
		),
		"AJAX_OPTION_ADDITIONAL" => "",
		"DATE_FORMAT" => "d-m-Y",
		"DATE_FORMAT_NO_YEAR" => "d-m",
		"DATE_TIME_FORMAT" => "d-m-Y H:i:s",
		"SHOW_DEP_HEAD_ADDITIONAL" => "N",
		"SHOW_YEAR" => "Y",
		"USE_VIEW_SELECTOR" => "Y",
		"TABLE_VIEW" => ".default",
		"EXTRANET_TYPE" => ""
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
