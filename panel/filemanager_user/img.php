<?php
require_once '../filemanager_user_core.php';
$core = new filemanager_user_core();
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
    else if(isset($_GET["filename_img_editor"]))
    {
        $core->userInfo();
        $Image = utf8_decode(base64_decode($_GET["filename_img_editor"]));
        $Image = end(explode("/", $Image));
        $Image = "../filemanager_temp/".$core->user_id."/".$Image;
        @$imginfo = getimagesize($Image);
        header("Content-type: ".$imginfo['mime']);
        readfile($Image);
    }
}
