<?php
if (!isset($core))
{
    require_once '../filemanager_user_core.php';
    $core = new filemanager_user_core();
    require_once '../filemanager_language_user.php';
}
if(isset($_SESSION["register_page_checker"]))
{
    if(isset($_POST["spam"]))
    {
        if($_POST["spam"] == $_SESSION["register_page_checker"])
        {
            if(isset($_POST["email"]) and isset($_POST["username"]))
            {
                $settings = $core->get_option("settings");
                if($settings->register == "on")
                {
                    $email = $_POST["email"];
                    $username = $_POST["username"];
                    $userId = 0;
                    $_SESSION["register_username_email_checked"] = true;
                    $core->check_username_email_of_user($username, $email, $userId);
                }
            }
        }
    }
}