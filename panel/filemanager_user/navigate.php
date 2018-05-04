<?php
if(isset($_GET["redirect"]))
{
    if (!isset($core))
    {
        require_once '../filemanager_user_core.php';
        $core = new filemanager_user_core();
    }
    $dir = utf8_decode(base64_decode($_GET["redirect"]));
    if(!is_dir($dir))
    {
        header("Location: .");
        exit();
    }
    // check the user base root when user login for security
    if($core->isLogin())
    {
        $key = "redirect_to_url_file_manager_go_user";
        $_SESSION[$key] = $dir;
        header('location: ./');
        exit;
    }
    else
    {
        $key = "redirect_to_url_file_manager_go_user";
        $_SESSION[$key] = $dir;
        header('location: ./');
        exit;
    }
}
else
{
    header("Location: .");
}
