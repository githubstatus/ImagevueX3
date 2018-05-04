<?php
if (!isset($core))
{
	require_once 'filemanager_core.php';
	$core = new filemanager_core();
	if($core->enforce_url()) return;
}
if ($core->isLogin())
{
    if($core->role == "admin")
    {
        if ($core->logout())
        {
        		session_destroy();
            header("Location: .");
        }
        else
        {
            require_once 'filemanager_language.php';
?>
        <script>
            var logout = alert("<?php language_filter("Logout_Error");?>");
            if(logout)
            {
                window.location.href = ".";
            }
            else
            {
                window.location.href = ".";
            }
        </script>
<?php
        }
    }
    else if($core->role == "user")
    {
        require_once 'filemanager_user_core.php';
        $core = new filemanager_user_core();
        require_once 'filemanager_language_user.php';
        if ($core->logout())
        {
        		session_destroy();
            header("Location: .");
        }
        else
        {
?>
            <script>
                var logout = alert("<?php language_filter("Logout Error", false, true)?>");
                if(logout)
                {
                    window.location.href = ".";
                }
                else
                {
                    window.location.href = ".";
                }
            </script>
<?php
        }
    }
    else
    {
        header("Location: .");
    }
}
else 
{
	header("Location: .");
}
?>