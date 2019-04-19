<?php
if (!isset($core))
{
	require_once '../filemanager_user_core.php';
	$core = new filemanager_user_core();
    $core->userInfo();
    require_once '../filemanager_language_user.php';
}
$extra_num = 0;

function set_new_name_for_file( $path, $name )
{
    global $extra_num;
    $extra_num++;
    $new_ext = explode(".", $name);
    $ext = end($new_ext);
    unset($new_ext[count($new_ext) - 1]);
    $new_name = implode($new_ext, ".");
    $new_name .= $extra_num.".".$ext;
    if( file_exists( $path.$new_name ) )
    {
        return set_new_name_for_file($path, $name);
    }
    return $new_name;
}

function get_file_url() {
    $https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0 ||
        !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
    return
        ($https ? 'https://' : 'http://').
        (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
        (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
            ($https && $_SERVER['SERVER_PORT'] === 443 ||
            $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
        substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
}

function little_name_filter($name)
{
    $newName = $name;
    $newName = str_replace("///", "/", $newName);
    $newName = str_replace("//", "/", $newName);
    return $newName;
}

if ($core->isLogin())
{
    if( isset( $_GET["action"] ) and $_GET["action"] == "delete_file" and isset( $_GET["delete_file_dir"] ) and isset( $_GET["delete_file_path"] ) ) {
        if( $core->user_can_do_it( $core->user_id, "remove_folders", $core->user_limitation ) ) {
            $dir = urldecode( $_GET["delete_file_dir"] );
            $file = urldecode( $_GET["delete_file_path"] );
            if(  $core->check_base_root( $dir ) ) {
                $info = new stdClass();
                $info->sucess = is_file($file) ? unlink( $file ) : true;
                $info->path = $file;
                $info->file = is_file( $file );
                echo $core->_encode(  array( $info ) );
            }
            exit;
        }
    }

	if(isset( $_POST["uploadDir"] ) and isset( $_FILES["datafile"] ) )
	{
        $_POST["uploadDir"] = little_name_filter( $_POST["uploadDir"]."/" );
        if($core->check_base_root($_POST["uploadDir"]))
        {
            if( $core->db_use ) {
                $allowedExts = $core->get_option("allow_uploads_".$core->user_id);
                $size = $core->get_option("user_upload_limit_".$core->user_id);
            }
            else {
                global $ALLOW_UPLOADER;
                $allowedExts = $ALLOW_UPLOADER;
                $size = 0;
            }
            $mim_types = $core->get_mime_type();
            if( isset( $mim_types->zip ) ) {
                array_push( $mim_types->zip, "application/x-zip-compressed" );
            }
            /*if( isset( $mim_types->docx ) ) {
                array_push( $mim_types->docx, "application/msword" );
            }
            if( isset( $mim_types->xlsx ) ) {
                array_push( $mim_types->xlsx, "application/vnd.ms-excel" );
            }
            if( isset( $mim_types->pptx ) ) {
                array_push( $mim_types->pptx, "application/vnd.ms-powerpoint" );
            }
            if(class_exists('finfo'))
            {
                $finfo = new finfo(FILEINFO_MIME);
            }*/
            $size = ($size * 1024) * 1024;
            $_result["files"] = array();
            $name = "";
            $ret["status"] = 'Error';
            $ret["msg"] = "";

            /*$temp = explode(".", $_FILES["datafile"]["name"]);
            $extension = end($temp);
            $extension = strtolower($extension);*/

            // extension
            $extension = strtolower(pathinfo($_FILES["datafile"]["name"], PATHINFO_EXTENSION));

            // mime type
            $mim_type = strtolower($_FILES["datafile"]["type"]);
            if(class_exists('finfo') && $_FILES["datafile"]["tmp_name"]){
            		$finfo = new finfo(FILEINFO_MIME);
                $mim_type = $finfo->file($_FILES["datafile"]["tmp_name"]);
                if(strpos($mim_type, ";"))
                {
                    $mim_type = explode(";", $mim_type);
                    $mim_type = $mim_type[0];
                }
            }

            // check if extension is allowed and mime type is not php-ish
            if (in_array($extension, $allowedExts) && stripos($mim_type, 'php') === false) {


            /*if (in_array($extension, $allowedExts)) {
                if(isset($mim_types->$extension))
                {
                    if (in_array($mim_type, $mim_types->$extension))
                    {*/
                        if ($_FILES["datafile"]["error"] > 0) {
                            $ret["msg"] = language_filter("Return Code", true).': ' . $_FILES["datafile"]["error"];
                        } else {
                            //$name = $_FILES["datafile"]["name"];
                            $name = str_replace('%22', '"', $_FILES["datafile"]["name"]);

                            // PHP orientation
                            if(X3Config::$config["back"]["panel"]["upload_resize"]["orientation"] === 'server'){
                            	require_once('../x3.image-orientation.php');
                            	fix_orientation($_FILES["datafile"]["tmp_name"], $extension, X3Config::$config["back"]["panel"]["upload_resize"]["quality"]);
                            }

                            if (file_exists($_POST["uploadDir"] . $_FILES["datafile"]["name"]))
                            {
                                $name = set_new_name_for_file($_POST["uploadDir"], $name);
                            }

                            if(move_uploaded_file($_FILES["datafile"]["tmp_name"], $_POST["uploadDir"] . $name))
                            {
                                $ret["status"] = "Success";
                                $ret["msg"] = language_filter("has been uploaded.", true);
                            }
                            else
                            {
                                $ret["msg"] = language_filter("Can not upload", true).' '.$name;
                            }
                        }
                    /*} else {
                        $ret["msg"] = language_filter("Invalid file", true).': '.$_FILES["datafile"]["name"];
                    }
                }
                else
                {
                    if ($_FILES["datafile"]["error"] > 0)
                    {
                        $ret["msg"] = language_filter("Return Code", true).': ' . $_FILES["datafile"]["error"];
                    }
                    else
                    {
                        $name = $_FILES["datafile"]["name"];
                        if (file_exists($_POST["uploadDir"] . $_FILES["datafile"]["name"]))
                        {
                            $name = set_new_name_for_file($_POST["uploadDir"], $name);
                        }
                        if(move_uploaded_file($_FILES["datafile"]["tmp_name"], $_POST["uploadDir"] . $name))
                        {
                            $ret["status"] = "Success";
                            $ret["msg"] = language_filter("has been uploaded.", true);
                        }
                        else
                        {
                            $ret["msg"] = language_filter("Can not upload", true).' '.$name;
                        }
                    }
                }*/
            } else {
                echo $ret["msg"] = language_filter("Invalid file", true).': '.$_FILES["datafile"]["name"];
            }

            $url = get_file_url()."/".$_POST["uploadDir"].rawurlencode($name);
            $url = str_replace( "panel/filemanager_user", "", $url );
            $url = str_replace( "../", "", $url );
            $ext = pathinfo( $_POST["uploadDir"].$name, PATHINFO_EXTENSION );
            $ext = strtolower($ext);
            if(in_array($ext, array('png', 'jpg', 'jpeg', 'gif'))) {
                $thumbnail_url = $url;
                list($image_width, $image_height) = getimagesize($url);
            } else {
                $thumbnail_url = "filemanager_assets/file.png";
                $image_width = false;
                $image_height = false;
            }
            $info = array(
                "url" => $url,
                "thumbnailUrl" => $thumbnail_url,
                "name" => $name,
                "type" => $mim_type,
                "size" => $_FILES["datafile"]["size"],
                "width" => $image_width,
                "height" => $image_height,
                "deleteUrl" =>  get_file_url()."/upload.php?action=delete_file&delete_file_path=".urlencode( $_POST["uploadDir"].$name )."&delete_file_dir=".urlencode( $_POST["uploadDir"] ),
                "deleteType" => "GET"
            );
            if(empty($ret["status"]) || $ret["status"] != "Success" ) {
                $info["error"] = $ret["msg"];
            }
            array_push( $_result["files"], $info );

            header('Vary: Accept');
            if (isset($_SERVER['HTTP_ACCEPT']) &&
                (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
                header('Content-type: application/json');
            } else {
                header('Content-type: text/plain');
            }
            $core->touchme();
            echo $core->_encode( $_result );
            die();
        }
	}
}
?>
