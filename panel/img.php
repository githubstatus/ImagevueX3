<?php
require_once 'filemanager_core.php';
$core = new filemanager_core();
if ($core->isLogin())
{
    if(isset($_GET["filename"]))
    {
        $Image = utf8_decode(base64_decode($_GET["filename"]));
        if($core->check_base_root($Image))
        {
            @$imginfo = getimagesize($Image);
            header("Content-type: ".$imginfo['mime']);
            readfile($Image);
        }
    }
}