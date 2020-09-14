<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$this->addExternalCss(SITE_TEMPLATE_PATH."/css/sidebar.css");

$this->setFrameMode(true);

if (count($arResult["USERS"]) < 1)
	return;

$this->SetViewTarget("sidebar", 300);
?>

<div class="sidebar-widget sidebar-widget-birthdays">
	<div class="sidebar-widget-top">
		<div class="sidebar-widget-top-title"><?=GetMessage("WIDGET_BIRTHDAY_TITLE")?></div>
	</div>
	<?
	$i = 0;
	foreach ($arResult["USERS"] as $arUser):
		if(!$arUser["show_Bday"] && SITE_ID != 's1') continue;
		$site_dir = rtrim(SITE_DIR, "/");
		$DETAIL_URL = $arUser["DETAIL_URL"];
		if (strpos($DETAIL_URL, $site_dir) === false) {
			$DETAIL_URL = $site_dir . $arUser["DETAIL_URL"];
		}
		//rtrim(SITE_DIR, "/") . 
	?>
	<a href="<?=$DETAIL_URL?>" class="sidebar-widget-item<?if(++$i == count($arResult["USERS"])):?> widget-last-item<?endif?><?if ($arUser["IS_BIRTHDAY"]):?> today-birth<?endif?>">
		<span class="user-avatar user-default-avatar"
			<?if (isset($arUser["PERSONAL_PHOTO"]["src"])):?>
				style="background: url('<?=$arUser["PERSONAL_PHOTO"]["src"]?>') no-repeat center; background-size: cover;"
			<?endif?>>
		</span>
		<?if ($arUser["IS_BIRTHDAY"]):?>
		<span class="user-avatar user-default-avatar" 
				style="background: url('/upload/dannebrog-50.gif') no-repeat center; background-size: cover; float: right; border-radius: unset;">
		</span>
		<?endif?>
		<span class="sidebar-user-info">
			<span class="user-birth-name"><?=CUser::FormatName($arParams['NAME_TEMPLATE'], $arUser, true);?></span>
			<span class="user-birth-date"><?
			if ($arUser["IS_BIRTHDAY"])
			{
				?><?=$arUser["CURRENT_AGE"] . " " . FormatDate("today"); ?>!<?
			}
			else
			{
				?><?=FormatDateEx(
					$arUser["PERSONAL_BIRTHDAY"],
					false,
					$arParams['DATE_FORMAT'.($arParams['SHOW_YEAR'] == 'Y' || $arParams['SHOW_YEAR'] == 'M' && $arUser['PERSONAL_GENDER'] == 'M' ? '' : '_NO_YEAR')]
				);
			}
			?></span>
		</span>
	</a>
	<?endforeach?>
</div>