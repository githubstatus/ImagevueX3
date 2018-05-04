<?php
require_once 'filemanager_core.php';
$core = new filemanager_core();
function cleantmp()
{
    $seconds_old = 3600;
    $directory = "../filemanager_temp";

    if( !$dirhandle = @opendir($directory) )
        return;

    while( false !== ($filename = readdir($dirhandle)) )
    {
        if( $filename != "." and $filename != ".." and is_file($directory. "/". $filename))
        {
            $filename = $directory. "/". $filename;

            if( @filemtime($filename) < (time()-$seconds_old) )
                @unlink($filename);
        }
    }
}
if ($core->isLogin())
{
    if(isset($_GET["filename"]))
    {
        $file = utf8_decode(base64_decode($_GET["filename"]));
        $info = $file;
        if($core->check_base_root($info))
        {
            if (file_exists($file))
            {
                //cleantmp();
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($info));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($info));
                @ob_clean();
                @flush();
                readfile($info);
                ignore_user_abort(true);
                if (connection_aborted())
                {
                    @unlink($info);
                }
                @unlink($info);
                exit;
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
    }
    else if(isset($_GET["show"]))
    {
        $file = utf8_decode(base64_decode($_GET["show"]));
        $info = $file;
        if($core->check_base_root($info))
        {
            if (file_exists($file))
            {
                //cleantmp();
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($info));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($info));
                @ob_clean();
                @flush();
                readfile($info);
                exit;
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