<?php
if (!isset($core))
{
    require_once 'filemanager_core.php';
    $core = new filemanager_core();
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    if ($core->isLogin())
    {
        if(isset($_POST["username_check"]) and isset($_POST["email_check"]) and isset($_POST["dir_check"]))
        {
            $dir_check = str_replace("../", ROOT_DIR_NAME."/", $_POST["dir_check"]);
            if(!is_dir($dir_check))
            {
                echo "dir";
                exit();
            }
            $user_id = 0;
            if(isset($_POST["check_id"]))
                $user_id = $_POST["check_id"];
            $core->check_username_email_of_user($_POST["username_check"], $_POST["email_check"], $user_id);
        }
    }
}
