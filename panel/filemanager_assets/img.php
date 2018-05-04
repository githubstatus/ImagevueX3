<?php
function check_image_valid($img)
{
    switch($img)
    {
        case "preloader":
            return "../filemanager_assets/ajax-loader.gif";
        break;

        case "bg":
            return "../filemanager_img/pattern/bg.png";
        break;

        case "zip":
            return "../filemanager_img/zip.png";
        break;

        case "directory":
            return "../filemanager_img/directory.png";
        break;

        case "picture":
            return "../filemanager_img/picture.png";
        break;

        case "file":
            return "../filemanager_img/file.png";
        break;

        case "fancybox_sprite":
            return "";
        break;

        default:
            $check_ext = strtolower(end(explode(".", $img)));
            if($check_ext == "png" or $check_ext == "jpg" or $check_ext == "jpeg" or $check_ext == "gif")
            {
                if(isset($_GET["fancy"]))
                {
                    if(is_file("../filemanager_img/fancy/".$img)) return "../filemanager_img/fancy/".$img;
                }
                else
                {
                    if(is_file("../filemanager_img/".$img)) return "../filemanager_img/".$img;
                }
            }
        break;
    }
    return null;
}
if(isset($_GET["img"]))
{
    $Image = check_image_valid($_GET["img"]);
    if($Image != null)
    {
        $imginfo = getimagesize($Image);
        header("Content-type: ".$imginfo['mime']);
        readfile($Image);
    }
}
