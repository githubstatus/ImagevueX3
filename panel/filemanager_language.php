<?php
global $language;

// In this file you can translate the Admin Panel's terms and phrases of Lift File Manager to your own language :)
// Please be carful and don't change the words which are inside [Brackets]

/*
 * Basic Settings And Global Characters
 */

if( !isset( $_SESSION["filemanager_language"] ) ) {
    $role = "admin";
    if( !defined( "DEFAULT_LNG" ) ) {
        define( "DEFAULT_LNG", "English" );
    }
    require_once __DIR__."/filemanager_assets/lng/".DEFAULT_LNG.".php";
}
else {
    $role = "admin";
    $lng = $_SESSION["filemanager_language"];
    require_once __DIR__."/filemanager_assets/lng/".$lng.".php";
}


/*
 * Warning! Please don't change the below function
 */

function language_filter($text, $ret = false, $script = false)
{
    global $language;
    $key = str_replace(" ", "_", $text);
    if($ret)
    {
        if($script == true)
        {
            return addslashes($language[$key]);
        }
        else
        {
            return $language[$key];
        }

    }
    else
    {
        if($script == true)
        {
            echo addslashes($language[$key]);
        }
        else
        {
        		echo isset($language[$key]) ? $language[$key] : '';
        }

    }
}
?>