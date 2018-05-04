<?php
//
// jQuery File Tree PHP Connector
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// Output a list of files for jQuery File Tree
//


function dir_contains_children_dirs( $dir ) {
    $result = false;
    if($dh = opendir($dir)) {
        while (!$result && ($file = readdir($dh))) {
            if( $file !== "." and $file !== ".." and is_dir($dir.'/'.$file)) {
                $result = true;
                break;
            }
        }
        closedir($dh);
    }
    return $result;
}

function check_numeric( $txt ) {
    if( is_numeric( substr( $txt, 0, 1 ) ) ) {
        $txt = substr($txt, 1);
        if( substr( $txt, 0, 1 ) == "." ) {
            return true;
        }
        return check_numeric( $txt );
    }
    return false;
}

if (!isset($core))
{
    require_once '../filemanager_user_core.php';
    $core = new filemanager_user_core();
    $core->userInfo();
}
if ($core->isLogin())
{
    $ignored = array('.', '..', 'filemanager_user_core.php','config.php', 'filemanager_config.php', 'filemanager_core.php', 'filemanager_language.php', 'filemanager_language_user.php', '.htaccess', 'filemanager_js', 'filemanager_install', 'filemanager_css', 'filemanager_backups', 'filemanager_admin', 'filemanager_img', 'filemanager_assets', 'filemanager_user', 'filemanager_temp', 'filemanager_fonts', 'services', 'sitemap', 'json', 'feed');
    $new_ignored = $core->get_option("deny_folders_".$core->user_id);
    if(!empty($new_ignored))
    {
        $ignored = array_merge($ignored, $new_ignored);
    }
    $allow_ext = $core->get_option("allow_extensions_".$core->user_id);

    $_POST['dir'] = urldecode($_POST['dir']);


    $sign = "..";
    if(isset($_POST['sign']))
    {
        $sign = urldecode($_POST['sign']);
        if($sign == "../".ROOT_DIR_NAME."/")
        {
            $sign = $core->user_dir."/";
        }
        else
        {
            $sign = "./".$core->user_dir."/";
        }
    }
    $dir_root = "..";

    if( file_exists(@$root . $_POST['dir']) ) {
        $files = scandir(@$root . $_POST['dir']);
        natcasesort($files);
        if( count($files) > 3 ) { /* The 2 accounts for . and .. */
            echo "<ul class=\"jqueryFileTree left_open_all_dir\" style=\"display: none;\">";
            // All dirs
            foreach( $files as $file ) {
                if (in_array($file, $ignored)) continue;
                if( file_exists(@$root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir(@$root . $_POST['dir'] . $file) ) {
                    $id = $_POST['dir'] . $file;
                    $class = "x3_hidden";
                    if($file == "custom") {
                    	$class = "x3_custom";
                    } else if(substr($file, -1) == "_" || in_array($file,array('json','feed','sitemap'))) {
                      $class = "x3_system";
                    } else if( check_numeric( $file ) ) {
                      $class = "x3_numbered";
                    }
                    $hasChildren = dir_contains_children_dirs( $id );
                    if( $hasChildren ) {
                        $hasChildren = "yes";
                    }
                    else {
                        $hasChildren = "no";
                    }
                    $id = str_replace("../", "", $id);
                    $id = str_replace(".", "_", $id);
                    $id = str_replace("/", "_", $id);
                    echo "<li class=\"directory collapsed directory_hover ".$class."\" onclick=\"fileTreeToggle('filemanager_user/', this)\" data-children=\"".$hasChildren."\" id=\"".$id."\" data-class=\"".$class."\" rel=\"" . htmlentities($_POST['dir'] . $file, ENT_QUOTES, "UTF-8") . "/\"><a href=\"javascript:;\" onclick=\"lick = false; showFileManager('" . addslashes(htmlentities($_POST['dir'] . $file, ENT_QUOTES, "UTF-8")) . "/');\" id=\"FILEMANAGER_NO_COLLAPSE\" rel=\"FILEMANAGER_NO_COLLAPSE\">" . htmlentities($file, ENT_QUOTES, "UTF-8") . "</a></li>";
                }
            }
            echo "</ul>";
        }
    }
}

?>