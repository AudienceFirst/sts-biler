<?php

require_once(dirname(__FILE__).'/config.php');

// if (DEV_MODE) {
    ini_set('display_errors', 1);
// }

require_once(dirname(__FILE__).'/lang_dk.php');

function forceMenuDimser(&$arMenu)
{
    if (empty($arMenu) || !$arMenu) {
        return false;
    }

    global $USER;


    $arMenu[] = array(
        'Dimser',
        file_exists($_SERVER["DOCUMENT_ROOT"].SITE_DIR."ddb/index.php") ? SITE_DIR."ddb/" : SITE_DIR,
        array(),
        array(
            "name" => "dimser_list",
            "counter_id" => "dimser-list",
            "menu_item_id" => "menu_dimser_list",
            "my_tools_section" => false,
        ),
        ""
    );
}
