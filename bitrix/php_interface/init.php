<?php

require_once(dirname(__FILE__).'/config.php');

// if (DEV_MODE) {
    ini_set('display_errors', 1);
// }

require_once(dirname(__FILE__) . '/lang_dk.php');

require_once(dirname(__FILE__) . '/include/make/functions.php');
require_once(dirname(__FILE__) . '/include/make/notifications.php');

//require_once(dirname(__FILE__) . '/include/ddb/ddb_mssql_database.php');
//require_once(dirname(__FILE__) . '/include/ddb/ddb_freebusy.php');


function dump_log( $log )
{
    $filename = $_SERVER["DOCUMENT_ROOT"].'/mailerlog.txt';
    $dumpContent = '';

    if (!file_exists($filename)){}
    if (!$handle = fopen($filename, 'a+')){}

    if (is_writable($filename)){
        $dumpContent .= date('d-m-y h:i:s')." : ";
        $dumpContent .= print_r($log, 1)." - bitrix.detdigitalebilhus.dk \n";

        if (fwrite($handle, $dumpContent) === FALSE){
            echo "Cannot write to file ($filename)";
            exit;
        }
        
        fclose($handle);
    }
}


AddEventHandler("blog", "OnBeforePostAdd", "handleOnBeforePostAdd");

function handleOnBeforePostAdd(&$arFields)
{
    dump_log($arFields);
}

function mobileSonetGroupStream($post)
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
