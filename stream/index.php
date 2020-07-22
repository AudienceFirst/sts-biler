<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetPageProperty("title", "DET DIGITALE BILHUS");
?>
<?$APPLICATION->IncludeComponent("bitrix:intranet.structure.birthday.nearest", "widget_home", Array(
	"AJAX_MODE" => "N",	// Enable AJAX mode
		"AJAX_OPTION_ADDITIONAL" => "",	// Additional ID
		"AJAX_OPTION_HISTORY" => "N",	// Emulate browser navigation
		"AJAX_OPTION_JUMP" => "N",	// Enable scrolling to component's top
		"AJAX_OPTION_STYLE" => "Y",	// Enable styles loading
		"CACHE_TIME" => "3600",	// Cache time (sec.)
		"CACHE_TYPE" => "A",	// Cache type
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DATE_FORMAT" => "d-m-Y",	// Date Format
		"DATE_FORMAT_NO_YEAR" => (LANGUAGE_ID=="en")?"j. F":((LANGUAGE_ID=="de")?"j. F":"j F"),	// Date Format (without year)
		"DATE_TIME_FORMAT" => "d.m.Y H:i:s",	// Date And Time Format
		"DEPARTMENT" => "0",	// Department/Office
		"DETAIL_URL" => "/company/personal/user/#USER_ID#/",
		"NAME_TEMPLATE" => "",	// Name Format
		"NUM_USERS" => "50",	// Show Users
		"PATH_TO_CONPANY_DEPARTMENT" => "/company/structure.php?set_filter_structure=Y&structure_UF_DEPARTMENT=#ID#",	// Template of Department Page Path
		"PM_URL" => "/company/personal/messages/chat/#USER_ID#/",	// Personal Message Page
		"SHOW_LOGIN" => "Y",	// Show Login Name if no required user name fields are available
		"SHOW_YEAR" => "Y",	// Show Year of Birth
		"STRUCTURE_FILTER" => "structure",	// Name of Company Structure Page Filter
		"STRUCTURE_PAGE" => "structure.php",	// Company Structure Page
		"USER_PROPERTY" => array(	// Custom Fields for Export
			0 => "PERSONAL_PHONE",
			1 => "PERSONAL_MOBILE",
			2 => "WORK_PHONE",
			3 => "UF_DEPARTMENT",
		),
		"COMPONENT_TEMPLATE" => "widget"
	),
	false
);?>

<?$APPLICATION->IncludeComponent(
	"bitrix:calendar.events.list", 
	"widget_home", 
	array(
		"B_CUR_USER_LIST" => "N",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"CALENDAR_SECTION_ID" => "0",
		"CALENDAR_TYPE" => "company_calendar",
		"DETAIL_URL" => "/calendar/index.php",
		"EVENTS_COUNT" => "10",
		"FUTURE_MONTH_COUNT" => "2",
		"INIT_DATE" => "--Current Date--",
		"COMPONENT_TEMPLATE" => "widget_home"
	),
	false
);
?>

<?
if (SITE_TEMPLATE_ID !== "bitrix24")
	return;
?>&nbsp;

<?

$APPLICATION->IncludeComponent(
	"bitrix:socialnetwork.log.ex",
	"",
	Array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_SHADOW" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AUTH" => "Y",
		"AVATAR_SIZE" => 100,
		"AVATAR_SIZE_COMMENT" => 100,
		"BLOG_ALLOW_POST_CODE" => "Y",
		"BLOG_GROUP_ID" => "1",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CONTAINER_ID" => "log_external_container",
		"DATE_TIME_FORMAT" => "F j, Y h:i a",
		"FORUM_ID" => "#FORUM_ID#",
		"ITEMS_COUNT" => "32",
		"NAME_TEMPLATE" => CSite::GetNameFormat(),
		"NEW_TEMPLATE" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PATH_TO_CONPANY_DEPARTMENT" => SITE_DIR."company/structure.php?set_filter_structure=Y&structure_UF_DEPARTMENT=#ID#",
		"PATH_TO_SEARCH_TAG" => SITE_DIR."search/?tags=#tag#",
		"PHOTO_COMMENTS_TYPE" => "FORUM",
		"PHOTO_FORUM_ID" => "#PHOTO_FORUM_ID#",
		"PHOTO_USER_IBLOCK_ID" => "#PHOTO_USER_IBLOCK_ID#",
		"PHOTO_USER_IBLOCK_TYPE" => "photos",
		"PHOTO_USE_CAPTCHA" => "N",
		"PHOTO_USE_COMMENTS" => "Y",
		"RATING_TYPE" => "",
		"SET_LOG_CACHE" => "N",
		"SET_NAV_CHAIN" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_EVENT_ID_FILTER" => "Y",
		"SHOW_LOGIN" => "Y",
		"SHOW_RATING" => "",
		"SHOW_SETTINGS_LINK" => "Y",
		"SHOW_YEAR" => "M",
		"USE_COMMENTS" => "Y"
	)
);

?>

&nbsp;

<?$APPLICATION->IncludeComponent(
	"bitrix:intranet.bitrix24.banner",
	"",
Array(),
null,
Array(
	'HIDE_ICONS' => 'N'
)
);?>&nbsp;<?
if(CModule::IncludeModule('intranet')):
	$APPLICATION->IncludeComponent("bitrix:intranet.ustat.status", "", array(),	false);
endif;?>
<?
if(CModule::IncludeModule('calendar')):
	$APPLICATION->IncludeComponent("bitrix:calendar.events.list", "widget", array(
		"CALENDAR_TYPE" => "user",
		"B_CUR_USER_LIST" => "Y",
		"INIT_DATE" => "",
		"FUTURE_MONTH_COUNT" => "1",
		"DETAIL_URL" => "/company/personal/user/#user_id#/calendar/",
		"EVENTS_COUNT" => "5",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600"
		),
		false
	);
endif;?>
<?if ($GLOBALS["USER"]->IsAuthorized())
{
	$APPLICATION->IncludeComponent("bitrix:socialnetwork.blog.blog", "important",
		Array(
			"BLOG_URL" => "",
			"FILTER" => array(">UF_BLOG_POST_IMPRTNT" => 0, "!POST_PARAM_BLOG_POST_IMPRTNT" => array("USER_ID" => $GLOBALS["USER"]->GetId(), "VALUE" => "Y")),
			"FILTER_NAME" => "",
			"YEAR" => "",
			"MONTH" => "",
			"DAY" => "",
			"CATEGORY_ID" => "",
			"GROUP_ID" => array(),
			"USER_ID" => $GLOBALS["USER"]->GetId(),
			"SOCNET_GROUP_ID" => 0,
			"SORT" => array(),
			"SORT_BY1" => "",
			"SORT_ORDER1" => "",
			"SORT_BY2" => "",
			"SORT_ORDER2" => "",
			//************** Page settings **************************************
			"MESSAGE_COUNT" => 0,
			"NAV_TEMPLATE" => "",
			"PAGE_SETTINGS" => array("bDescPageNumbering" => false, "nPageSize" => 10),
			//************** URL ************************************************
			"BLOG_VAR" => "",
			"POST_VAR" => "",
			"USER_VAR" => "",
			"PAGE_VAR" => "",
			"PATH_TO_BLOG" => "/company/personal/user/#user_id#/blog/",
			"PATH_TO_BLOG_CATEGORY" => "",
			"PATH_TO_BLOG_POSTS" => "/company/personal/user/#user_id#/blog/important/",
			"PATH_TO_POST" => "/company/personal/user/#user_id#/blog/#post_id#/",
			"PATH_TO_POST_EDIT" => "/company/personal/user/#user_id#/blog/edit/#post_id#/",
			"PATH_TO_USER" => "/company/personal/user/#user_id#/",
			"PATH_TO_SMILE" => "/bitrix/images/socialnetwork/smile/",
			//************** ADDITIONAL *****************************************
			"DATE_TIME_FORMAT" => (LANGUAGE_ID == "en") ? "F j, Y h:i a" : ((LANGUAGE_ID == "de") ? "j. F Y H:i:s" : "d.m.Y H:i:s"),
			"NAME_TEMPLATE" => "",
			"SHOW_LOGIN" => "Y",
			"AVATAR_SIZE" => 100,
			"SET_TITLE" => "N",
			"SHOW_RATING" => "N",
			"RATING_TYPE" => "",
			"MESSAGE_LENGTH" => 56,
			//************** CACHE **********************************************
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => 3600,
			"CACHE_TAGS" => array("IMPORTANT", "IMPORTANT".$GLOBALS["USER"]->GetId()),
			//************** Template Settings **********************************
			"OPTIONS" => array(array("name" => "BLOG_POST_IMPRTNT", "value" => "Y")),
		),
		null
	);
}
?>



<?
/*
$APPLICATION->IncludeComponent(
	"bitrix:blog.popular_posts",
	"widget",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DATE_TIME_FORMAT" => (LANGUAGE_ID=="en")?"F j, Y h:i a":((LANGUAGE_ID=="de")?"j. F Y H:i:s":"d.m.Y H:i:s"),
		"GROUP_ID" => 1,
		"MESSAGE_COUNT" => "5",
		"MESSAGE_LENGTH" => "100",
		"PATH_TO_BLOG" => "/company/personal/user/#user_id#/blog/",
		"PATH_TO_GROUP_BLOG_POST" => "/workgroups/group/#group_id#/blog/#post_id#/",
		"PATH_TO_POST" => "/company/personal/user/#user_id#/blog/#post_id#/",
		"PATH_TO_USER" => "/company/personal/user/#user_id#/",
		"PERIOD_DAYS" => "8",
		"SEO_USER" => "Y",
		"SORT_BY1" => "RATING_TOTAL_VALUE",
		"USE_SOCNET" => "Y",
		"WIDGET_MODE" => "Y"
	)
);
*/
?>

<?if(CModule::IncludeModule('bizproc')):
	$APPLICATION->IncludeComponent(
		'bitrix:bizproc.task.list',
		'widget',
		array(
			'COUNTERS_ONLY' => 'Y',
			'USER_ID' => $USER->GetID(),
			'PATH_TO_BP_TASKS' => '/company/personal/bizproc/',
			'PATH_TO_MY_PROCESSES' => '/company/personal/processes/',
		),
		null,
		array('HIDE_ICONS' => 'N')
	);
endif;?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>