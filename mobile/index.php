<?
define("BX_MOBILE_LOG", true);
if (isset($_REQUEST['BX_SESSION_LOCK']) && $_REQUEST['BX_SESSION_LOCK'] !== 'Y'
    && !($_POST["ACTION"] == "ADD_POST" || $_POST["ACTION"] == "EDIT_POST")
)
{
    define('BX_SECURITY_SESSION_READONLY', true);
}


require($_SERVER["DOCUMENT_ROOT"]."/mobile/headers.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
AddEventHandler("blog", "BlogImageSize", "ResizeMobileLogImages", 100, $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/components/bitrix/socialnetwork.blog.post/mobile/functions.php");

\Bitrix\Main\Data\AppCacheManifest::getInstance()->setExcludeImagePatterns(
    array("fontawesome","images/newpost","images/files", "/crm","images/im", "images/post", "images/notification", "images/messages", "images/tasks")
);

if (IsModuleInstalled("bitrix24"))
    GetGlobalID();

global $USER;

function sonetSiteIdByStream($stream)
{
    $stream = trim($stream);

    $site = 's1';
    switch ($stream) {

        case 'DR50':
        $site = 'mh';
        break; // sts biler
        
        case 'DR51':
        $site = 'lb';
        break; // era biler
        
        case 'DR53':
        $site = 'py';
        break; // mfa biler
        
        case 'DR54':
        $site = 'rc';
        break; // bil og co
        
        case 'DR55':
        $site = 'jf';
        break; // nhe biler
        
        case 'DR56':
        $site = 'ku';
        break; // autohallen
        
        case 'DR52':
        $site = 'qy';
        break;// sdk biler

        case 'DR1':
        default:
        $site = 's1';
        break; // ddb/ main stream
    }

    return $site; 
}

function sonetGroupStream($post)
{

    if (!$post || empty($post))
        return intval($_REQUEST["group_id"]);

    global $USER;

    $sonetStreams = [
        12 => 'DR1', // ddb/ main stream
        17 => 'DR50', // sts biler
        19 => 'DR51', // era biler
        21 => 'DR53', // mfa biler
        23 => 'DR54', // bil og co
        25 => 'DR55', // nhe biler
        27 => 'DR56', // autohallen
        29 => 'DR52' // sdk biler
    ];

    $departmentGroups = [
        'DDB' => 12,
        'STS' => 17, // sts biler
        'ERA' => 19, // era biler
        'MFA' => 21, // mfa biler
        'BIL' => 23, // bil og co
        'NHE' => 25, // nhe biler
        'AUT' => 27, // autohallen
        'SDK' => 29 // sdk biler
    ];

    $usergroups = $USER->GetUserGroup($USER->GetID());
    sort($usergroups);

    dump_log($usergroups);

    $defaultSonet = 0; // DDB
    reset($usergroups);
    foreach ($usergroups as $key => $value) {
        
        if ($value == $departmentGroups['DDB'])
            continue;

        if (!$defaultSonet && in_array($value, $departmentGroups)) {
            $defaultSonet = $value;
            break;
        }
    }

    $socnetStreams = [];

    // get users
    foreach ($post['SPERM']['U'] as $spermUser) {
        
        $sonetUser = str_ireplace('u', '', $spermUser);

        // post to sender's stream by default for main admin
        // if (intval($sonetUser) === 1)
        //     continue;

        // get socnetUser socnet departments

        // get socnetUser groups
        $sonetUsergroups = $USER->GetUserGroup($sonetUser);
        sort($sonetUsergroups);

        // dump_log($defaultSonet);
        // dump_log($usergroups);
        // dump_log($sonetUsergroups);

        // what happens here is, we match the sonet user's group with the groups by the user who posted in the stream
        // we apply posting rules accordingly (SB-59)
        // $streamFound = false;
        // reset($usergroups);
        // foreach ($usergroups as $refkey => $refvalue) {

        //     if ($refvalue == $departmentGroups['DDB'])
        //         continue;

        //     if (!in_array($refvalue, $departmentGroups))
        //         continue;

        //     // assign post to matching department stream (1 matching dept stream only)
        //     if (in_array($refvalue, $sonetUsergroups)) {

        //         // check first if we can post to sender's stream
        //         if (in_array($defaultSonet, $sonetUsergroups)) {
        //             $socnetStreams[$defaultSonet][] = $sonetUser;
        //         }
        //         else {
        //             $socnetStreams[$refvalue][] = $sonetUser;
        //         }

        //         $streamFound = true;
        //         break;
        //     }
        // }

        // // DDB is main /stream/, this will be default option only if no matching dept stream is found
        // if (!$streamFound) {
        //     $socnetStreams[ $departmentGroups['DDB'] ][] = $sonetUser;
        // }

        if (in_array($defaultSonet, $sonetUsergroups)) {
            $socnetStreams[ $defaultSonet ][] = $sonetUser;
        }
        else {
            $socnetStreams[ $departmentGroups['DDB'] ][] = $sonetUser;
        }
    }

    reset($socnetStreams);
    
    $sonetKeys = array_keys($socnetStreams);

    dump_log($socnetStreams);
    dump_log($sonetKeys);

    if (empty($sonetKeys) || count($sonetKeys) > 1) {
        $sonetGroupToPost = $sonetStreams[ $departmentGroups['DDB'] ];
    }
    else {
        $sonetGroupToPost = $sonetStreams[ current($sonetKeys) ];   
    }

    return $sonetGroupToPost;
}

if (
    $_POST["ACTION"] == "ADD_POST"
    || $_POST["ACTION"] == "EDIT_POST"
)
{
    dump_log($_POST);
    
    function LocalRedirectHandler(&$url)
    {
        $bSuccess = false;

        if (strpos($url, "?") > 0)
        {
            $arUrlParam = explode("&", substr($url, strpos($url, "?")+1));
            foreach ($arUrlParam as $url_param)
            {
                list($key, $val) = explode("=", $url_param, 2);
                if ($key == "new_post_id")
                {
                    $new_post_id = $val;
                    break;
                }
            }
        }

        if (
            strpos($url, "success=Y") > 0
            && intval($new_post_id) > 0
        )
        {
            unset($_SESSION["MFU_UPLOADED_FILES"]);
            unset($_SESSION["MFU_UPLOADED_DOCS"]);
            unset($_SESSION["MFU_UPLOADED_FILES_".$GLOBALS["USER"]->GetId()]);
            unset($_SESSION["MFU_UPLOADED_DOCS_".$GLOBALS["USER"]->GetId()]);
            $GLOBALS["APPLICATION"]->RestartBuffer();

            $blogPostLivefeedProvider = new \Bitrix\Socialnetwork\Livefeed\BlogPost;

            $rsLogSrc = CSocNetLog::GetList(
                array(),
                array(
                    "EVENT_ID" => $blogPostLivefeedProvider->getEventId(),
                    "SOURCE_ID" => $new_post_id
                ),
                false,
                false,
                array("ID"),
                array(
                    "CHECK_RIGHTS" => "Y",
                    "USE_SUBSCRIBE" => "N"
                )
            );
            if ($arLogSrc = $rsLogSrc->Fetch())
            {
                ob_start();
                ?><?$GLOBALS["APPLICATION"]->IncludeComponent("bitrix:mobile.socialnetwork.log.ex", ".default", array(
                        "NEW_LOG_ID" => intval($arLogSrc["ID"]),
                        "PATH_TO_LOG_ENTRY" => SITE_DIR."mobile/log/?detail_log_id=#log_id#",
                        "PATH_TO_LOG_ENTRY_EMPTY" => SITE_DIR."mobile/log/?empty=Y",
                        "PATH_TO_USER" => SITE_DIR."mobile/users/?user_id=#user_id#",
                        "SET_LOG_CACHE" => "N",
                        "IMAGE_MAX_WIDTH" => 550,
                        "DATE_TIME_FORMAT" => ""
                    ),
                    false,
                    Array("HIDE_ICONS" => "Y")
                );?><?
                $postText = ob_get_contents();
                ob_end_clean();

                $bSuccess = true;
            }
        }

        $GLOBALS["APPLICATION"]->RestartBuffer();

        if (!$bSuccess)
        {
            echo ($_POST["response_type"] == "json" ? CUtil::PhpToJSObject(array("error" => "*")) : "*");
        }
        else
        {
            echo ($_POST["response_type"] == "json" ? CUtil::PhpToJSObject(array("text" => $postText)) : $postText);
        }

        die();
    }

    $LocalRedirectHandlerId = AddEventHandler('main', 'OnBeforeLocalRedirect', "LocalRedirectHandler");

    $sonetStream = sonetGroupStream($_POST);

    // $sonetSiteId = SITE_ID;
    $sonetSiteId = sonetSiteIdByStream($sonetStream);

    dump_log($sonetStream);
    dump_log($sonetSiteId);

    $params =  array(
            "ID" => ($_POST["ACTION"] == "EDIT_POST" && intval($_POST["post_id"]) > 0 ? intval($_POST["post_id"]) : 0),
            "USER_ID" => ($_POST["ACTION"] == "EDIT_POST" && intval($_POST["post_user_id"]) > 0 ? intval($_POST["post_user_id"]) : $GLOBALS["USER"]->GetID()),
            "PATH_TO_POST_EDIT" => $APPLICATION->GetCurPageParam("success=Y&new_post_id=#post_id#"), // redirect when success
            "PATH_TO_POST" => "/company/personal/user/".$GLOBALS["USER"]->GetID()."/blog/#post_id#/", // search index
            "USE_SOCNET" => "Y",
            "SOCNET_GROUP_ID" => intval($_REQUEST["group_id"]),
            "SOCNET_RIGHTS" => $sonetStream,
            "SONET_SITE_ID" => $sonetSiteId,
            "GROUP_ID" => (IsModuleInstalled("bitrix24") ? $GLOBAL_BLOG_GROUP[SITE_ID] : 1),
            "MOBILE" => "Y"
        );
    dump_log($params);

// exit();
    $APPLICATION->IncludeComponent("make:socialnetwork.blog.post.edit", "mobile_empty", array(
            "ID" => ($_POST["ACTION"] == "EDIT_POST" && intval($_POST["post_id"]) > 0 ? intval($_POST["post_id"]) : 0),
            "USER_ID" => ($_POST["ACTION"] == "EDIT_POST" && intval($_POST["post_user_id"]) > 0 ? intval($_POST["post_user_id"]) : $GLOBALS["USER"]->GetID()),
            "PATH_TO_POST_EDIT" => $APPLICATION->GetCurPageParam("success=Y&new_post_id=#post_id#"), // redirect when success
            "PATH_TO_POST" => "/company/personal/user/".$GLOBALS["USER"]->GetID()."/blog/#post_id#/", // search index
            "USE_SOCNET" => "Y",
            "SOCNET_GROUP_ID" => intval($_REQUEST["group_id"]),
            "SOCNET_RIGHTS" => $sonetStream,
            "SONET_SITE_ID" => $sonetSiteId,
            "GROUP_ID" => (IsModuleInstalled("bitrix24") ? $GLOBAL_BLOG_GROUP[SITE_ID] : 1),
            "MOBILE" => "Y"
        ),
        false,
        Array("HIDE_ICONS" => "Y")
    );

    RemoveEventHandler('main', 'OnBeforeLocalRedirect', $LocalRedirectHandlerId);

    $GLOBALS["APPLICATION"]->RestartBuffer();
    echo ($_POST["response_type"] == "json" ? CUtil::PhpToJSObject(array("error" => "*")) : "*");
    die();
}

$filter = false;
if ($_GET["favorites"] == "Y")
{
    $filter = "favorites";
}
elseif ($_GET["my"] == "Y")
{
    $filter = "my";
}
elseif ($_GET["important"] == "Y")
{
    $filter = "important";
}
elseif ($_GET["work"] == "Y")
{
    $filter = "work";
}
elseif ($_GET["bizproc"] == "Y")
{
    $filter = "bizproc";
}
elseif ($_GET["blog"] == "Y")
{
    $filter = "blog";
}

// get blog group ID based on user's usergroup
$groupId = userBlogGroupId();

$loadDefault = false;

// check if workgroup stream is being loaded
$workgroupId = !empty($_REQUEST['group_id']) ? $_REQUEST['group_id'] : 0;
if ($workgroupId) {
    CModule::IncludeModule("socialnetwork");
    
    if ($socnetGroup = CSocNetGroup::getById($workgroupId))
        $loadDefault = true;

}

?>
<pre style='display:none;'>test</pre>
<?

$component = 'make:mobile.socialnetwork.log.ex';
// if ($loadDefault)
    // $component = 'bitrix:mobile.socialnetwork.log.ex';

?><?$APPLICATION->IncludeComponent($component, ".default", array(
        // "GROUP_ID" => intval($_GET["group_id"]),
        "GROUP_ID" => $workgroupId ? $workgroupId : $groupId,
        "LOG_ID" => intval($_GET["detail_log_id"]),
        "FAVORITES" => ($_GET["favorites"] == "Y" ? "Y" : "N"),
        "FILTER" => $filter,
        "CREATED_BY_ID" => (isset($_GET["created_by_id"]) && intval($_GET["created_by_id"]) > 0 ? intval($_GET["created_by_id"]) : false),
        "PATH_TO_LOG_ENTRY" => SITE_DIR."mobile/log/?detail_log_id=#log_id#",
        "PATH_TO_LOG_ENTRY_EMPTY" => SITE_DIR."mobile/log/?empty=Y",
        "PATH_TO_USER" => SITE_DIR."mobile/users/?user_id=#user_id#",
        "PATH_TO_GROUP" => SITE_DIR."mobile/log/?group_id=#group_id#",
        "PATH_TO_CRMCOMPANY" => SITE_DIR."mobile/crm/company/?page=view&company_id=#company_id#",
        "PATH_TO_CRMCONTACT" => SITE_DIR."mobile/crm/contact/?page=view&contact_id=#contact_id#",
        "PATH_TO_CRMLEAD" => SITE_DIR."mobile/crm/lead/?page=view&lead_id=#lead_id#",
        "PATH_TO_CRMDEAL" => SITE_DIR."mobile/crm/deal/?page=view&deal_id=#deal_id#",
        'PATH_TO_TASKS_SNM_ROUTER' => SITE_DIR.'mobile/tasks/snmrouter/'
            . '?routePage=__ROUTE_PAGE__'
            . '&USER_ID=#USER_ID#'
            . '&GROUP_ID=' . (int) $_GET['group_id']
            . '&LIST_MODE=TASKS_FROM_GROUP',
        "SET_LOG_CACHE" => "Y",
        "IMAGE_MAX_WIDTH" => 550,
        "DATE_TIME_FORMAT" => ((intval($_GET["detail_log_id"]) > 0 || $_REQUEST["ACTION"] == "CONVERT") ? "j F Y G:i" : ""),
        "CHECK_PERMISSIONS_DEST" => "N",
    ),
    false,
    Array("HIDE_ICONS" => "Y")
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>