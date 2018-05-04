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
			echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
			// All dirs
            if($_POST['dir'] == $core->user_dir."/")
                echo "<li class=\"directory \"><a href=\"javascript:;\" id=\"filemanager_home_directory_root\" rel=\"".$sign."\">" . htmlentities($dir_root) . "</a></li>";

            foreach( $files as $file ) {
				if (in_array($file, $ignored)) continue;
				if( file_exists(@$root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir(@$root . $_POST['dir'] . $file) ) {
					echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file, ENT_QUOTES, "UTF-8") . "/\">" . htmlentities($file, ENT_QUOTES, "UTF-8") . "</a></li>";
				}
			}
			// All files
			foreach( $files as $file ) {
				if (in_array($file, $ignored)) continue;
                $_ext = explode(".", $file);
                $_ext = end( $_ext );
                $ext = strtolower($_ext);
                if(!in_array($ext, $allow_ext)) continue;

				if( file_exists(@$root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir(@$root . $_POST['dir'] . $file) ) {
					$ext = preg_replace('/^.*\./', '', $file);
					echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file, ENT_QUOTES, "UTF-8") . "\">" . htmlentities($file, ENT_QUOTES, "UTF-8") . "</a></li>";
				}
			}
			echo "</ul>";	
		}
	}
}

?>