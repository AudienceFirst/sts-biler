<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (count($arResult["ITEMS"]) < 1)
	return;

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

	$arResult["ITEMS"][$i] = $arItem;
}

#$arResult["ITEMS"] = $arEvents;

?>