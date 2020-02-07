<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule("socialnetwork");


$arGroups = Array(12, 17, 19, 21, 23, 25, 27, 29);

$getUserGroups = $USER->GetUserGroupArray();
$filterGroupsID = Array();
foreach($getUserGroups as $group_id){
	if(in_array($group_id, $arGroups)){
		$filterGroupsID[] = $group_id;
	}
}

$res = CUser::GetList ($by = "name", $order = "asc", $arFilter=Array("ACTIVE"=>"Y", "GROUPS_ID"=>$filterGroupsID), $arParams=Array());

$user_list = Array();
$user_list[] = Array(
	"NAME" => "All employees",
	"ID" => 0,
	"OUTSECTION" => true,
	"bubble_background_color" => "#A7F264",
	"bubble_text_color" => "#54901E"
);

// To do TAGS and WORK_DEPARTMENTS
while($result = $res->GetNext()){
	if($USER->GetID() == $result['ID']) continue;
	$img_res = false;
	$imageFile = CFile::GetFileArray($result['PERSONAL_PHOTO']);
	if ($imageFile !== false) {
		$arFileTmp = CFile::ResizeImageGet($imageFile,
			["width" => 64,"height" => 64],
			BX_RESIZE_IMAGE_PROPORTIONAL,
			false
		);
		$img_res = $arFileTmp["src"];
	}

	$user_list[] = Array(
		"NAME" => $result['NAME']." ".$result['LAST_NAME'],
		"ID" => $result['ID'],
		"IMAGE" => $img_res,
		"URL" => $result['ID'],
		"PAGE" => Array(
			"url" => $result['ID'],
			"bx24ModernStyle" => true,
			"usetitle" => true
		),
		"TAGS" => "",
		"WORK_POSITION" => "",
        "WORK_DEPARTMENTS" => Array(
    		"STS Biler",
        	"Herning",
        	"Holstebro",
        	"Management",
        	"Ikast",
        	"Lemvig",
        	"Skive",
        	"Det Digitale Bilhus"
        ),
        "bubble_background_color" => "#BCEDFC",
        "bubble_text_color" => "#1F6AB5"

	);
}

$arGroupFilterMy = [
	"USER_ID" => $USER->GetID(),
	"<=ROLE" => SONET_ROLES_USER,
	"GROUP_ACTIVE" => "Y",
	"!GROUP_CLOSED" => "Y",
];

$dbGroups = CSocNetUserToGroup::GetList(
	["GROUP_NAME" => "ASC"],
	$arGroupFilterMy,
	false,
	false,
	['ID', 'GROUP_ID', 'GROUP_NAME', 'GROUP_SITE_ID', 'GROUP_IMAGE_ID']
);
$group_list = Array();
while($res = $dbGroups->Fetch()){
	$img_res = false;
	$imageFile = CFile::GetFileArray($res['GROUP_IMAGE_ID']);
	if ($imageFile !== false) {
		$arFileTmp = CFile::ResizeImageGet($imageFile,
			["width" => 64,"height" => 64],
			BX_RESIZE_IMAGE_PROPORTIONAL,
			false
		);
		$img_res = $arFileTmp["src"];
	}
	$group_list[] = Array(
		"NAME" => $res['GROUP_NAME'],
		"ID" => $res['GROUP_ID'],
		"IMAGE" => $img_res,
		"bubble_background_color" => "#FFD5D5",
		"bubble_text_color" => "#B54827"
	);
}

// $group_list = Array(
// 	0 => Array(
// 		"NAME" => "DDB-IT Helpdesk",
// 		"ID" => 131,
// 		"IMAGE" => "/upload/socialnetwork/431/it-afdeling.png",
// 		"bubble_background_color" => "#FFD5D5",
// 		"bubble_text_color" => "#B54827"
// 	)
// );

$customList = Array(
	"data" => Array(
		"a_users" => $user_list,
		"b_groups" => $group_list
	),
	"names" => Array(
		"a_users" => "Employees",
		"b_groups" => "Workgroups"
	)
);

print_r(json_encode($customList));
?>