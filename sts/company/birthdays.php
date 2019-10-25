<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/intranet/public/company/birthdays.php");
$APPLICATION->SetTitle(GetMessage("COMPANY_TITLE"));
?><?$APPLICATION->IncludeComponent(
	"make:intranet.structure.birthday.nearest", "bitrix24",
	Array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_SHADOW" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DATE_FORMAT" => "F j, Y",
		"DATE_FORMAT_NO_YEAR" => "F j",
		"DATE_TIME_FORMAT" => "F j, Y h:i a",
		"DEPARTMENT" => "0",
		"NAME_TEMPLATE" => "",
		"NUM_USERS" => "25",
		"PATH_TO_CONPANY_DEPARTMENT" => "/sts/company/structure.php?set_filter_structure=Y&structure_UF_DEPARTMENT=#ID#",
		"PATH_TO_VIDEO_CALL" => "/sts/company/personal/video/#USER_ID#/",
		"PM_URL" => "/sts/company/personal/messages/chat/#USER_ID#/",
		"SHOW_FILTER" => "N",
		"SHOW_LOGIN" => "Y",
		"SHOW_YEAR" => "M",
		"STRUCTURE_FILTER" => "structure",
		"STRUCTURE_PAGE" => "structure.php",
		"USER_PROPERTY" => array("PERSONAL_PHOTO","PERSONAL_PHONE","UF_DEPARTMENT","UF_PHONE_INNER","UF_SKYPE")
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>