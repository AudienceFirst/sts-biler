<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (count($arResult["ITEMS"]) < 1)
	return;

$arEvents = Array();
$curUserId = CCalendar::GetCurUserId();
$ts = time();
$fromLimit = CCalendar::Date($ts, false);
$ts = CCalendar::Timestamp($fromLimit);
$toLimit = CCalendar::Date(mktime(0, 0, 0, date("m", $ts) + $arParams["FUTURE_MONTH_COUNT"], date("d", $ts), date("Y", $ts)), false);
$arFilter = array(
	'CAL_TYPE' => "user",
	'FROM_LIMIT' => $fromLimit,
	'TO_LIMIT' => $toLimit,
	'DELETED' => 'N',
	'ACTIVE_SECTION' => 'Y'
);

$CEvents = CCalendarEvent::GetList(
            array(
                'arFilter' => $arFilter,
                'parseRecursion' => true,
                'fetchAttendees' => true,
                'userId' => $curUserId,
                'fetchMeetings' => 'user',
                'preciseLimits' => true,
                'skipDeclined' => true
            )
        );

foreach($CEvents as $i => $event):
	$event['_DETAIL_URL'] = CHTTP::urlAddParams($arParams['DETAIL_URL'], array(
		'EVENT_ID' => $event['ID'],
		'EVENT_DATE' => CCalendar::Date(CCalendar::Timestamp($event['DATE_FROM']), false)
	));

	$fromTs = CCalendar::Timestamp($event['DATE_FROM']);
	$toTs = $fromTs + $event['DT_LENGTH'];

	$event['~FROM_TO_HTML'] = CCalendar::GetFromToHtml($fromTs, $toTs, $event['DT_SKIP_TIME'] == 'Y', $event['DT_LENGTH']);

	$arResult["ITEMS"][] = $event;
endforeach;

foreach($arResult["ITEMS"] as $i => $arItem)
{
	$dateParse = ParseDateTime($arItem["DATE_FROM"]);
	$arItem["ICON_DAY"] = $dateParse["DD"];

	$arItem['DT_FROM'] = FormatDateFromDB($arItem['DT_FROM']);
	$arItem['DT_TO'] = FormatDateFromDB($arItem['DT_TO']);
	$arItem['DATE_FROM'] = FormatDateFromDB($arItem['DATE_FROM']);
	$arItem["WEEK_DAY"] = FormatDate("D", $dateFrom);

	#Section
	$arItem["SECTION"] = CCalendarSect::GetById($arItem["SECT_ID"]);

	$arEvents[] = $arItem;
}

usort($arEvents, 'sort_by_date');

$arResult["ITEMS"] = $arEvents;

function sort_by_date($a, $b){
	$t1 = strtotime($a['DATE_FROM']);
	$t2 = strtotime($b['DATE_FROM']);

	return $t1 - $t2;
}
?>