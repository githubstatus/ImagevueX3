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
        if($core->role == "admin")
        {
            if (isset($_POST["admin_id"]))
            {
                $username = urlencode($_POST["admin_username"]);
                $firstname = urlencode($_POST["admin_firstname"]);
                $lastname = urlencode($_POST["admin_lastname"]);
                $email = urlencode($_POST["admin_email"]);
                $id = $_POST["admin_id"];
                $core->editProfile($id, $username, $firstname, $lastname, $email);
            }

            if (isset($_POST["admin_change_pass_id"]))
            {
                $id = $_POST["admin_change_pass_id"];
                $admin_newPass = $_POST["admin_newPass"];
                $core->editPassword($id, $admin_newPass);
            }
        }
    }
    else
    {
        header("Status: 404 Not Found");
    }
}
else
{
    header("Status: 404 Not Found");
}
?>