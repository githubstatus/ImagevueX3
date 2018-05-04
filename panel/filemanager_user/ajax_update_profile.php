<?php
if (!isset($core))
{
    require_once '../filemanager_user_core.php';
    $core = new filemanager_user_core();
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    if ($core->isLogin())
    {
        if (isset($_POST["user_id"]))
        {
            $username = urlencode($_POST["user_username"]);
            $firstname = urlencode($_POST["user_firstname"]);
            $lastname = urlencode($_POST["user_lastname"]);
            $email = urlencode($_POST["user_email"]);
            $id = $_POST["user_id"];
            $core->editProfile($id, $username, $firstname, $lastname, $email);
        }

        if (isset($_POST["user_change_pass_id"]))
        {
            $id = $_POST["user_change_pass_id"];
            $user_newPass = $_POST["user_newPass"];
            $core->editPassword($id, $user_newPass);
        }
    }
    else
    {
        header("Status: 404 Not Found");
    }
}
?>