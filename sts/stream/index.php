<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetPageProperty("title", htmlspecialcharsbx(COption::GetOptionString("main", "site_name", "Bitrix24")));
?><?
if (SITE_TEMPLATE_ID !== "bitrix24")
	return;
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:intranet.structure.birthday.nearest",
	"widget",
	Array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DATE_FORMAT" => "d-m-Y",
		"DATE_FORMAT_NO_YEAR" => (LANGUAGE_ID=="en")?"j. F":((LANGUAGE_ID=="de")?"j. F":"j F"),
		"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
		"DEPARTMENT" => "0",
		"DETAIL_URL" => "/company/personal/user/#USER_ID#/",
		"NAME_TEMPLATE" => "",
		"NUM_USERS" => "4",
		"PATH_TO_CONPANY_DEPARTMENT" => "/company/structure.php?set_filter_structure=Y&structure_UF_DEPARTMENT=#ID#",
		"PM_URL" => "/company/personal/messages/chat/#USER_ID#/",
		"SHOW_LOGIN" => "Y",
		"SHOW_YEAR" => "Y",
		"STRUCTURE_FILTER" => "structure",
		"STRUCTURE_PAGE" => "structure.php",
		"USER_PROPERTY" => array("PERSONAL_PHONE","PERSONAL_MOBILE","WORK_PHONE","UF_DEPARTMENT")
	)
);?>
<?
/*
$APPLICATION->IncludeComponent(
	"bitrix:intranet.structure.birthday.nearest",
	"widget",
	Array(
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DATE_FORMAT" => "j F",
		"DATE_FORMAT_NO_YEAR" => (LANGUAGE_ID=="en")?"F j":((LANGUAGE_ID=="de")?"j. F":"j F"),
		"DEPARTMENT" => "0",
		"DETAIL_URL" => "/company/personal/user/#USER_ID#/",
		"NAME_TEMPLATE" => "",
		"NUM_USERS" => "4",
		"SHOW_LOGIN" => "Y",
		"SHOW_YEAR" => "N"
	)
);
*/
?>
<?$APPLICATION->IncludeComponent(
	"make:socialnetwork.log.ex",
	".default",
	Array(
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_SHADOW" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AUTH" => "Y",
		"AVATAR_SIZE" => "100",
		"AVATAR_SIZE_COMMENT" => "100",
		"BLOG_ALLOW_POST_CODE" => "Y",
		"BLOG_GROUP_ID" => "3",
		"CACHE_TIME" => "100",
		"CACHE_TYPE" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"CONTAINER_ID" => "log_external_container",
		"DATE_TIME_FORMAT" => "F j, Y h:i a",
		"FORUM_ID" => "#FORUM_ID#",
		"GROUP_VAR" => "",
		"ITEMS_COUNT" => "32",
		"LOG_CNT" => 20,
		"LOG_DATE_DAYS" => "7",
		"NAME_TEMPLATE" => CSite::GetNameFormat(),
		"NEW_TEMPLATE" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGE_VAR" => "",
		"PATH_TO_CONPANY_DEPARTMENT" => SITE_DIR."company/structure.php?set_filter_structure=Y&structure_UF_DEPARTMENT=#ID#",
		"PATH_TO_GROUP" => $folderWorkgroups."group/#group_id#/",
		"PATH_TO_SEARCH_TAG" => SITE_DIR."search/?tags=#tag#",
		"PATH_TO_USER" => $pathToUser,
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
		"SUBSCRIBE_ONLY" => "Y",
		"USER_VAR" => "",
		"USE_COMMENTS" => "Y"
	)
);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:intranet.bitrix24.banner",
	"",
Array(),
null,
Array(
	'HIDE_ICONS' => 'N'
)
);?>
<?
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
		"DETAIL_URL" => "/sts/company/personal/user/#user_id#/calendar/",
		"EVENTS_COUNT" => "5",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600"
		),
		false
	);
endif;?>
<?
/*
if(CModule::IncludeModule('tasks')):
	$APPLICATION->IncludeComponent(
		"bitrix:tasks.filter.v2",
		"widget",
		array(
			"VIEW_TYPE" => 0,
			"COMMON_FILTER" => array("ONLY_ROOT_TASKS" => "Y"),
			"USER_ID" => $USER->GetID(),
			"ROLE_FILTER_SUFFIX" => "",
			"PATH_TO_TASKS" => "/sts/company/personal/user/".$USER->GetID()."/tasks/",
			"CHECK_TASK_IN" => "R"
		),
		null,
		array("HIDE_ICONS" => "N")
	);
endif;
*/
?>
<?
if ($GLOBALS["USER"]->IsAuthorized())
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
			"PATH_TO_BLOG" => "/sts/company/personal/user/#user_id#/blog/",
			"PATH_TO_BLOG_CATEGORY" => "",
			"PATH_TO_BLOG_POSTS" => "/sts/company/personal/user/#user_id#/blog/important/",
			"PATH_TO_POST" => "/sts/company/personal/user/#user_id#/blog/#post_id#/",
			"PATH_TO_POST_EDIT" => "/sts/company/personal/user/#user_id#/blog/edit/#post_id#/",
			"PATH_TO_USER" => "/sts/company/personal/user/#user_id#/",
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
<?$APPLICATION->IncludeComponent(
	"bitrix:blog.popular_posts",
	"widget",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DATE_TIME_FORMAT" => (LANGUAGE_ID=="en")?"F j, Y h:i a":((LANGUAGE_ID=="de")?"j. F Y H:i:s":"d.m.Y H:i:s"),
		"GROUP_ID" => 1,
		"MESSAGE_COUNT" => "5",
		"MESSAGE_LENGTH" => "100",
		"PATH_TO_BLOG" => "/sts/company/personal/user/#user_id#/blog/",
		"PATH_TO_GROUP_BLOG_POST" => "/sts/workgroups/group/#group_id#/blog/#post_id#/",
		"PATH_TO_POST" => "/sts/company/personal/user/#user_id#/blog/#post_id#/",
		"PATH_TO_USER" => "/sts/company/personal/user/#user_id#/",
		"PERIOD_DAYS" => "8",
		"SEO_USER" => "Y",
		"SORT_BY1" => "RATING_TOTAL_VALUE",
		"USE_SOCNET" => "Y",
		"WIDGET_MODE" => "Y"
	)
);?>
<?if(CModule::IncludeModule('bizproc')):
	$APPLICATION->IncludeComponent(
		'bitrix:bizproc.task.list',
		'widget',
		array(
			'COUNTERS_ONLY' => 'Y',
			'USER_ID' => $USER->GetID(),
			'PATH_TO_BP_TASKS' => '/sts/company/personal/bizproc/',
			'PATH_TO_MY_PROCESSES' => '/sts/company/personal/processes/',
		),
		null,
		array('HIDE_ICONS' => 'N')
	);
endif;?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>