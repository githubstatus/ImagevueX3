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
    require_once 'filemanager_core.php';
    $core = new filemanager_core();
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    if ($core->isLogin())
    {
        $ignored = array('.', '..', 'filemanager_user_core.php', 'config.php', 'filemanager_config.php', 'filemanager_core.php', 'filemanager_language.php', 'filemanager_language_user.php', '.htaccess', 'filemanager_js', 'filemanager_install', 'filemanager_css', 'filemanager_backups', 'filemanager_admin', 'filemanager_img', 'filemanager_assets', 'filemanager_user', 'filemanager_temp', 'filemanager_fonts', 'services', 'sitemap', 'json', 'feed');

        $_POST['dir'] = urldecode($_POST['dir']);
        $sign = "..";
        if(isset($_POST['sign']))
        {
            $sign = urldecode($_POST['sign']);
            if($sign == ROOT_DIR_NAME)
            {
                $sign = "..";
            }
            else
            {
                $sign = "...";
            }
        }
        $dir_root = "..";

        if( file_exists(@$root . $_POST['dir']) ) {
            $files = scandir(@$root . $_POST['dir']);
            natcasesort($files);
            if( count($files) > 3 ) { /* The 2 accounts for . and .. */
                echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
                // All dirs
                if($_POST['dir'] == ROOT_DIR_NAME."/")
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
                    if( file_exists(@$root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir(@$root . $_POST['dir'] . $file) ) {
                        $ext = preg_replace('/^.*\./', '', $file);
                        if(strtolower($ext) != "yml")
                        echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file, ENT_QUOTES, "UTF-8") . "\">" . htmlentities($file, ENT_QUOTES, "UTF-8") . "</a></li>";
                    }
                }
                echo "</ul>";
            }
            else
            {
                //echo '<div class="alert alert-info"><center><b>NO FILES AND FOLDERS</b></center></div>';
            }
        }
    }
}
?>