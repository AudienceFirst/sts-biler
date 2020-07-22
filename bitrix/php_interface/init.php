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
        $dumpContent .= print_r($log, 1)." - develop.detdigitalebilhus.dk \n";

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