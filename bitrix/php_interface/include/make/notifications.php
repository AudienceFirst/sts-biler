<?php
// Det Digitale Bilhus
define("S1_BIRTHDAY_TEMPLATE_ID", 454);
define("S1_ANNIVERSARY_TEMPLATE_ID", 462);
// Bil og Co
define("RC_BIRTHDAY_TEMPLATE_ID", 455);
define("RC_ANNIVERSARY_TEMPLATE_ID", 468);
// SDK Biler
define("QY_BIRTHDAY_TEMPLATE_ID", 456);
define("QY_ANNIVERSARY_TEMPLATE_ID", 469);
// MFA Biler
define("PY_BIRTHDAY_TEMPLATE_ID", 457);
define("PY_ANNIVERSARY_TEMPLATE_ID", 463);
// STS Biler
define("MH_BIRTHDAY_TEMPLATE_ID", 458);
define("MH_ANNIVERSARY_TEMPLATE_ID", 464);
// ERA Biler
define("LB_BIRTHDAY_TEMPLATE_ID", 459);
define("LB_ANNIVERSARY_TEMPLATE_ID", 465);
// Autohallen
define("KU_BIRTHDAY_TEMPLATE_ID", 460);
define("KU_ANNIVERSARY_TEMPLATE_ID", 466);
// NHE Biler
define("JF_BIRTHDAY_TEMPLATE_ID", 461);
define("JF_ANNIVERSARY_TEMPLATE_ID", 467);

//Socnet Rights
define("S1_RIGHTS","DR414");
define("RC_RIGHTS","DR54");
define("QY_RIGHTS","DR52");
define("PY_RIGHTS","DR53");
define("MH_RIGHTS","DR50");
define("LB_RIGHTS","DR51");
define("KU_RIGHTS","DR56");
define("JF_RIGHTS","DR55");


#function trigger by bitrix agents
function activateEmployeeNotification()
{
    GLOBAL $USER;
    GLOBAL $DB;

    if (!is_object($USER))
    $USER = new CUser;

    CModule::IncludeModule('main');
    CModule::IncludeModule("socialnetwork");
    CModule::IncludeModule("blog");
    CModule::IncludeModule("xdimport");

    // EmployeeNotification::activateEmployeeNotification();

    $notification = new EmployeeNotification();
    $notification->activateEmployeeNotification();
    
    // exit();
    return "activateEmployeeNotification();";
}

function notifyAllEmployees($message, $arCodes = array("UA"), $tags){
    global $USER;
    
    CModule::IncludeModule("im");
    CModule::IncludeModule("socialnetwork");
    
    // $exclude_user = array();
    // foreach($arCodes as $key => $arCode){
    //     if(substr($arCode, 0, 1) === 'U' && $arCode != "UA"){
    //         unset($arCodes[$key]);
    //         $exclude_user[] = substr($arCode, 1);
    //     }
    // }
    
    $arUsers = CSocNetLogDestination::GetDestinationUsers($arCodes);
    // $filtered_user = array_diff($arUsers, $exclude_user);
    
    foreach($arUsers as $userId){
        $arFieldsIM = array("NOTIFY_MESSAGE" => $message,
            "NOTIFY_TYPE" => IM_NOTIFY_SYSTEM,
            "NOTIFY_MODULE" => "blog",
            "NOTIFY_EVENT" => "post",
            "NOTIFY_TAG" => $tags,
            "FROM_USER_ID" => 0,
            "TO_USER_ID" => $userId);
            
        CIMNotify::Add($arFieldsIM);
    }
}

function getDepartmentByUserID($ID){
    $deptList = Array();
    $arDept = Array(414 => "S1", 54 => "RC", 52 => "QY", 53 => "PY", 50 => "MH", 51 => "LB", 56 => "KU", 55 => "JF");
    $user = CUser::GetByID($ID)->Fetch();
    $res_dept = $user['UF_DEPARTMENT'];
    // foreach ($res_dept as $deptID) {
    //  if (array_key_exists($deptID, $arDept)) {

    //  }
    //  else{
            
    //  }
    // }
}

class EmployeeNotification
{
    public function __construct()
    {
        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
        CModule::IncludeModule('main');
        CModule::IncludeModule('iblock');
        CModule::IncludeModule("socialnetwork");
        CModule::IncludeModule("blog");
        CModule::IncludeModule("xdimport");

        GLOBAL $USER;
        GLOBAL $DB;

        if (!is_object($USER)) $USER = new CUser;

        ini_set("memory_limit", -1);
        @set_time_limit(0);
    }

    public function activateEmployeeNotification()
    {
        GLOBAL $DB;
        
        $strSql = "SELECT U.ID FROM b_user U JOIN b_uts_user UTS ON U.ID = UTS.VALUE_ID WHERE DATE_FORMAT(U.PERSONAL_BIRTHDAY,'%m-%d') = DATE_FORMAT(NOW(),'%m-%d') OR  DATE_FORMAT(UTS.UF_WORK_START,'%m-%d') = DATE_FORMAT(NOW(),'%m-%d')";
        
        $res = $DB->Query($strSql, false, $err_mess. __LINE__ );


        $arElements = array();
        while ($arRes = $res->Fetch())
        {
            $userID = intval($arRes["ID"]);

            $userGroups = CUser::GetUserGroup($userID);

            $groupEmails = $this->groupEmailTemplates($userGroups);
            $emailTemplates = current($groupEmails);
            $blogs = [];
            foreach ($userGroups as $gkey => $gvalue) {
                $blogs[] = $this->blogIdByGroupId($gvalue);
            }
            $blogs = array_unique($blogs);

            // group ID 12 is DDB employees
            // if(!in_array(12, $userGroups)){
            //  continue;
            // }

            $user = CUser::GetByID($userID)->Fetch();
            $fullname = trim($user["NAME"] . " " . $user["LAST_NAME"]);
            $jobtitle = $user["WORK_POSITION"];
            $department = $user["WORK_DEPARTMENT"];

            $user_photo_id = $user["PERSONAL_PHOTO"];
            $user_photo = "";
            if(!empty($user_photo_id)){
                $img = CFile::ResizeImageGet($user_photo_id, array('width'=>250, 'height'=>250), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                #$img['src'] = str_replace(" ", "%20", $img['src']);
                $filename = rawurlencode(basename($img['src']));
                $img['src'] = dirname($img['src'])."/".$filename;
                $user_photo = '<img src="'.$img['src'].'" width="'.$img['width'].'" height="'.$img['height'].'" />';
            }

            $user_flag = $user["WORK_COUNTRY"];
            $user_flag = '<img src="/assets/img/user-flag.gif" border="0" style="margin-left: 20px;">';
            
            $curr_day = date("d");
            $curr_month = date("m");
            $curr_year = date("Y");

            $array_keys = array(
                "#FULLNAME#",
                "#JOBTITLE#",
                "#DEPARTMENT#",
                "#USER_PHOTO#",
                "#USER_FLAG#",
                "#YEARS#"
            );

            #use birthday template
            if(!empty($user["PERSONAL_BIRTHDAY"]))
            {
                $day = date("d", strtotime($user["PERSONAL_BIRTHDAY"]));
                $month = date("m", strtotime($user["PERSONAL_BIRTHDAY"]));
                $year = date("Y", strtotime($user["PERSONAL_BIRTHDAY"]));
                $year_diff = $curr_year - $year;
                
                $array_values = array(
                    $fullname,
                    $jobtitle,
                    $department,
                    $user_photo,
                    $user_flag,
                    $year_diff
                );
                
                if($day == $curr_day && $month == $curr_month && $year_diff>0)
                {
                    // $rsEM = CEventMessage::GetByID(BIRTHDAY_TEMPLATE_ID);
                    $rsEM = CEventMessage::GetByID($emailTemplates['BIRTHDAY']);
                    $arEM = $rsEM->Fetch();

                    $subject = str_replace("#FULLNAME#", $fullname, $arEM["SUBJECT"]);
                    $message = str_replace($array_keys, $array_values, $arEM["MESSAGE"]);

                    $this->notifyEmployees($subject, $message, current($blogs));
                }
            }

            #use anniversary template
            if(!empty($user["UF_WORK_START"]))
            {
                $day = date("d", strtotime($user["UF_WORK_START"]));
                $month = date("m", strtotime($user["UF_WORK_START"]));
                $year = date("Y", strtotime($user["UF_WORK_START"]));
                $year_diff = $curr_year - $year;
                $arAnniversaryYears = array(10, 20, 25, 30, 40, 45, 50, 55, 60);
                
                if(!in_array($year_diff, $arAnniversaryYears)){
                    continue;
                }
                
                $array_values = array(
                    $fullname,
                    $jobtitle,
                    $department,
                    $user_photo,
                    $user_flag,
                    $year_diff
                );
            
                if($day == $curr_day && $month == $curr_month && $year_diff>0)
                {
                    // echo 'triggered work anniv';
                    
                    // $rsEM = CEventMessage::GetByID(ANNIVERSARY_TEMPLATE_ID);
                    $rsEM = CEventMessage::GetByID($emailTemplates['ANNIVERSARY']);
                    $arEM = $rsEM->Fetch();

                    $subject = str_replace("#FULLNAME#", $fullname, $arEM["SUBJECT"]);
                    $message = str_replace($array_keys, $array_values, $arEM["MESSAGE"]);

                    $this->notifyEmployees($subject, $message, current($blogs));
                }
            }
        }

    }

    function notifyEmployees($subject, $message, $blogId = ''){
        global $DB;
        
        $CTextParser = new \CTextParser();
        $message = $CTextParser->convertHTMLToBB($message);

        if (!empty($blogId)) {
            $blog = CBlog::GetByID($blogId);
        } else {
            $BLOG_OWNER_ID = "1";
            $blog = CBlog::GetByOwnerID($BLOG_OWNER_ID);
        }
        
        // $socnetPerms = array("UA");
        $socnetPerms = array("DR50");

        $arBlogFields = array(
            "TITLE" => $subject,
            "DETAIL_TEXT" => (!empty($message)) ? $message : " ",
            "DETAIL_TEXT_TYPE" => "text",
            "BLOG_ID" => $blog["ID"],
            "AUTHOR_ID" => $blog["OWNER_ID"],
            "=DATE_CREATE" => $DB->GetNowFunction(),
            "=DATE_PUBLISH" => $DB->GetNowFunction(),
            "PATH" => "/company/personal/user/" . $blog["OWNER_ID"] . "/blog/#post_id#/",
            "URL" => $blog["URL"],
            "ENABLE_COMMENTS" => $blog["ENABLE_COMMENTS"],
            "HAS_SOCNET_ALL" => "N",
            "PUBLISH_STATUS" => BLOG_PUBLISH_STATUS_PUBLISH,
            "PERMS_POST" => array(),
            "PERMS_COMMENT" => array(),
            // "SOCNET_RIGHTS" => array("UA"),
            "SOCNET_RIGHTS" => $socnetPerms,
            "MICRO" => "Y",
            "SKIP_POST_HANDLER" => "Y",
        );

        $blogPostID = CBlogPost::Add($arBlogFields);
        
        $arBlogFields["ID"] = $blogPostID;
        $arParamsNotify = Array(
            "bSoNet" => true,
            "UserID" => $blog["OWNER_ID"],
            "user_id" => $blog["OWNER_ID"],
            "PATH_TO_POST" => $arBlogFields["PATH"],
        );

        $log_id = CBlogPost::Notify($arBlogFields, array(), $arParamsNotify);

        //notify all employees
        $url = str_replace("#post_id#", $blogPostID, $arBlogFields["PATH"]);
        $new_subject .= '<a href="'.$url.'">'.$subject.'</a>';

        $tag = "BLOG|POST|".$blogPostID;

        notifyAllEmployees($new_subject, $socnetPerms, $tag);

        return $blogPostID;
    }

     public function groupEmailTemplates($userGroups)
    {
        $templates = [];
        
        // sts
        if (in_array(17, $userGroups)) {
            
            $templates[] = [
                'BIRTHDAY' => MH_BIRTHDAY_TEMPLATE_ID,
                'ANNIVERSARY' => MH_ANNIVERSARY_TEMPLATE_ID
            ];
            
        }

        // era
        if (in_array(19, $userGroups)) {
            $templates[] = [
                'BIRTHDAY' => LB_BIRTHDAY_TEMPLATE_ID,
                'ANNIVERSARY' => LB_ANNIVERSARY_TEMPLATE_ID
            ];
        }

        // mfa
        if (in_array(21, $userGroups)) {
            $templates[] = [
                'BIRTHDAY' => PY_BIRTHDAY_TEMPLATE_ID,
                'ANNIVERSARY' => PY_ANNIVERSARY_TEMPLATE_ID
            ];
        }

        // bilogco
        if (in_array(23, $userGroups)) {
            $templates[] = [
                'BIRTHDAY' => RC_BIRTHDAY_TEMPLATE_ID,
                'ANNIVERSARY' => RC_ANNIVERSARY_TEMPLATE_ID
            ];
        }

        // nhe
        if (in_array(25, $userGroups)) {

            $templates[] = [
                'BIRTHDAY' => JF_BIRTHDAY_TEMPLATE_ID,
                'ANNIVERSARY' => JF_ANNIVERSARY_TEMPLATE_ID
            ];
        }

        // autohallen
        if (in_array(27, $userGroups)) {

            $templates[] = [
                'BIRTHDAY' => KU_BIRTHDAY_TEMPLATE_ID,
                'ANNIVERSARY' => KU_ANNIVERSARY_TEMPLATE_ID
            ];
        }

        // sdk
        if (in_array(29, $userGroups)) {

            $templates[] = [
                'BIRTHDAY' => QY_BIRTHDAY_TEMPLATE_ID,
                'ANNIVERSARY' => QY_ANNIVERSARY_TEMPLATE_ID
            ];
        }

        // ddb
        if (in_array(12, $userGroups)) {

            $templates[] = [
                'BIRTHDAY' => S1_BIRTHDAY_TEMPLATE_ID,
                'ANNIVERSARY' => S1_ANNIVERSARY_TEMPLATE_ID
            ];

        }

        return $templates;
    }

    // source: http://167.71.33.87/bitrix/admin/blog_blog.php?lang=da&&filter=Y&set_filter=Y
    public function blogIdByGroupId($group)
    {
        $group = intval($group);

        // ddb; default
        $blog = 1;

        switch ($group) {

            // sts
            case 17:
                $blog = 3;
                break;


            // era
            case 19:
                $blog = 5;
                break;


            // mfa
            case 21:
                $blog = 1; // none defined
                break;


            // bilogco
            case 23:
                $blog = 9;
                break;


            // nhe
            case 25:
                $blog = 1; // none defined
                break;


            // autohallen
            case 27:
                $blog = 13;
                break;

            // sdk
            case 29:
                $blog = 16;
                break;
                
            // ddb
            case 12:
            // default:
                $blog = 1;
                break;
        }

        return $blog;
        
    }
}

AddEventHandler("blog", "OnPostAdd", "OnPostAddHandler");
#AddEventHandler("blog", "OnBeforePostAdd", "OnPostAddHandler");
function OnPostAddHandler($ID, &$arFields)
{
    if(!isset($arFields["SKIP_POST_HANDLER"]))
    {
        $url = str_replace("#post_id#", $ID, $arFields["PATH"]);
        $subject = "Et nyt opslag er blevet tilføjet: ";
        $subject .= '<a href="'.$url.'">'.$arFields["TITLE"].'</a>';

        $tag = "BLOG|POST|".$ID;

        notifyAllEmployees($subject, $arFields["SOCNET_RIGHTS"], $tag);
    }
    
    return $arFields;
}
