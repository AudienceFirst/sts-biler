<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arParams['NAME_TEMPLATE'] = $arParams['NAME_TEMPLATE'] ? $arParams['NAME_TEMPLATE'] : CSite::GetNameFormat(false);

foreach ($arResult['USERS'] as $key => $arUser)
{
	if ($arUser['PERSONAL_PHOTO'])
	{
		$imageFile = CFile::GetFileArray($arUser['PERSONAL_PHOTO']);
		if ($imageFile !== false)
		{
			$arUser["PERSONAL_PHOTO"] = CFile::ResizeImageGet(
				$imageFile,
				array("width" => 100, "height" => 100),
				BX_RESIZE_IMAGE_EXACT,
				true
			);
		}
		else
			$arUser["PERSONAL_PHOTO"] = false;
	}
	
	$arResult['USERS'][$key] = $arUser;
	
	$date = ParseDateTime($arUser["PERSONAL_BIRTHDAY"]);
	$current_year = date("Y");
	$current_month = date("m");
	$current_day = date("d");

	$nDate = new DateTime('now');
	$nDate->settime(0,0);
	$bDate = new DateTime($current_year ."-" . $date["MM"] ."-" . $date["DD"]);
	$interval = date_diff($nDate, $bDate);

	if( $interval->format('%a') > 60 || $bDate < $nDate ){

		unset($arResult['USERS'][$key]);
	}

	if ($arUser["IS_BIRTHDAY"]) {
        $nowyear = date("Y");
        $yrDate = ParseDateTime($arUser["PERSONAL_BIRTHDAY"]);

        $arResult['USERS'][$key]["CURRENT_AGE"] = $nowyear - intval($yrDate["YYYY"]);
    }
}

$arResult['SITE_ID'] = SITE_ID;
//added code modified 10-05-2019
if(SITE_ID != 's1'):
//$rsSites = CSite::GetByID(SITE_ID)->Fetch();
$site = Array("py" => 53, "mh" => 50, "lb" => 51, "ku" => 56, "jf" => 55, "rc" => 54, "qy" => 52);


foreach ($arResult['USERS'] as $key => $user){
	$arDept = $user['UF_DEPARTMENT'];

	$sec_id = $site[SITE_ID];
	if(in_array($sec_id, $arDept)){
		$arResult['USERS'][$key]['show_Bday'] = true;
		continue;
	}
	else{
		CModule::IncludeModule('iblock');
		$ITEMS = Array();
		foreach($arDept as $dept){
			$nav = CIBlockSection::GetNavChain(false, $dept);
			while($arItem = $nav->Fetch()){
				$ITEMS[] = $arItem['ID'];
			}

		}
		if(in_array($sec_id, $arDept)){
			$arResult['USERS'][$key]['show_Bday'] = true;
			continue;
		}

		array_unique($ITEMS);
		if(in_array($sec_id, $ITEMS)){
			$arResult['USERS'][$key]['show_Bday'] = true;
			continue;
		}
	}

	$arResult['USERS'][$key]['show_Bday'] = false;
}
endif;
?>