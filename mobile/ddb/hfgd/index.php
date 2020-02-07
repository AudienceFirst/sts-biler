<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("HFGD - Hvordan Fanden Går Det?");
?>


<?


if ($USER->isAuthorized())
{
	$userData = Bitrix\Main\UserTable::getList(array(
		'select' => array('ID', 'NAME', 'UF_PHONE_INNER','WORK_PHONE', 'NAME', 'LAST_NAME'),
		'filter' => array(
		'=ID' => $USER->getId()
		)
	))->fetch();
}



?>


<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<link rel="stylesheet" href="/ddb_scripts/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue.css">
<style type="text/css">
/*Rules for sizing the icon*/
.material-icons.md-72 { font-size: 72px; }

i.icon-blue { color: #0a69b7; }


</style>




<div class="w3-container">



<? if( !empty(array_intersect(array(32), CUser::GetUserGroup($USER->GetID()))) ) { ?>
 <div class="w3-button w3-mobile w3-center" style="width:33%">
	 <a href="hfgd/">
  <i class="material-icons md-72 icon-blue">assessment</i>
  <p>SALGSAFDELING</p>
  </a>
</div>
<? } ?>

<? if( !empty(array_intersect(array(33), CUser::GetUserGroup($USER->GetID()))) ) { ?>
 <div class="w3-button w3-mobile w3-center" style="width:33%">
  <a href="bvlist/">
  <i class="material-icons md-72 icon-blue">local_car_wash</i>
  <p>MEKANISK</p>
  </a>
</div>
<? } ?>

<? if( !empty(array_intersect(array(33), CUser::GetUserGroup($USER->GetID()))) ) { ?>
 <div class="w3-button w3-mobile w3-center" style="width:33%">
  <a href="bvlist/">
  <i class="material-icons md-72 icon-blue">local_car_wash</i>
  <p>PLADE</p>
  </a>
</div>
<? } ?>


</div> 






<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>