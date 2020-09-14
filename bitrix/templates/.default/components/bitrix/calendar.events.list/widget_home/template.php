<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
$this->SetViewTarget("sidebar", 300);
$frame = $this->createFrame()->begin();

if (count($arResult["ITEMS"]) > 0):
?>

<div class="sidebar-widget sidebar-widget-calendar">
	<div class="sidebar-widget-top">
		<div class="sidebar-widget-top-title"><?=GetMessage("WIDGET_CALENDAR_TITLE")?></div>
		<a href="<?=$arParams["DETAIL_URL"]?>?EVENT_ID=NEW" class="plus-icon"></a>
	</div>
	<div class="sidebar-widget-content">
	<?foreach($arResult["ITEMS"] as $i => $arItem):?>
		<a data-bx-calendar-entry="<?=$arItem["ID"]?>" onclickx="BX.SidePanel.Slider('<?=$arItem["_DETAIL_URL"]?>');" href="<?=$arItem["_DETAIL_URL"]?>" class="sidebar-widget-item<?if($i == 0):?> widget-first-item<?endif?><?if($i == count($arResult["ITEMS"])-1):?> widget-last-item<?endif?>">
			<span class="calendar-color-label" style="background-color: <?=$arItem["SECTION"]["COLOR"];?>"></span>
			<span class="calendar-item-date" title="<?=$arItem["~FROM_TO_HTML"]?>"><?=$arItem["~FROM_TO_HTML"]?></span>
			<span class="calendar-item-text">
				<span class="calendar-item-link"><?=htmlspecialcharsbx($arItem["NAME"])?></span>
			</span>
			<span class="calendar-item-location"><?=CCalendar::GetTextLocation($arItem["LOCATION"])?></span>
		</a>
	<?endforeach?>
	</div>
</div><?
else:
	echo " "; //Buffering hack
endif;
$frame->end();
$this->EndViewTarget();