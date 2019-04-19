<?php
if(!isset($_POST["install"]))
{
    require_once '../config.php';
    require_once '../filemanager_assets/JSON.php';
}
class UPDATE_V_2_0_0 extends Services_JSON
{
    var $db;
    var $install_flag = false;
    function __construct()
    {
        $this->db = ($GLOBALS["___mysqli_ston"] = mysqli_connect(DB_HOST, DB_USER, DB_PASS));
        ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . constant('DB_NAME')));
    }

    public function update()
    {
        $alter_table = "ALTER TABLE  `filemanager_db` ADD  `ck_id` TEXT AFTER  `is_login` ,
                        ADD  `luck_time` DATETIME AFTER  `ck_id` ,
                        ADD  `luck_count` TINYINT AFTER  `luck_time`";
        if(mysqli_query($GLOBALS["___mysqli_ston"], $alter_table))
        {
            $alter_table = "ALTER TABLE  `filemanager_users` ADD  `ck_id` TEXT AFTER  `is_login` ,
                            ADD  `luck_time` DATETIME AFTER  `ck_id` ,
                            ADD  `luck_count` TINYINT AFTER  `luck_time` ,
                            ADD  `activation_key` TEXT AFTER  `luck_count`";
            if(mysqli_query($GLOBALS["___mysqli_ston"], $alter_table))
            {
                /*
                 * Mime type of upload extensions
                 */
                $mime_type = array(
                    "jpg" => array("image/jpeg", "image/pjpeg", "application/octet-stream"),
                    "jpeg" => array("image/jpeg", "image/pjpeg", "application/octet-stream"),
                    "bmp" => array("image/bmp", "application/octet-stream"),
                    "gif" => array("image/gif", "application/octet-stream"),
                    "pdf" => array("application/pdf", "application/zip", "application/octet-stream"),
                    "zip" => array("application/zip", "application/octet-stream", "application/download"),
                    "rar" => array("application/x-rar-compressed", "application/octet-stream", "application/download", "application/x-rar"),
                    "doc" => array("application/msword", "text/html", "application/octet-stream"),
                    "docx" => array("application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/zip", "application/octet-stream"),
                    "xls" => array("application/vnd.ms-excel", "text/html", "application/octet-stream"),
                    "xlsx" => array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/zip", "application/octet-stream"),
                    "ppt" => array("application/vnd.ms-powerpoint", "text/html", "application/vnd.ms-office", "application/octet-stream"),
                    "pptx" => array("application/vnd.openxmlformats-officedocument.presentationml.presentation", "application/zip", "application/octet-stream"),
                    "psd" => array("image/photoshop", "image/x-photoshop", "image/psd", "application/photoshop", "application/psd", "zz-application/zz-winassoc-psd", "application/octet-stream"),
                    "flv" => array("video/x-flv", "application/octet-stream"),
                    "mp3" => array("audio/mpeg", "audio/mp3", "audio/mpeg3", "audio/x-mpeg-3", "video/mpeg", "video/x-mpeg", "application/octet-stream", "video/mp4"),
                    "mp4" => array("video/mp4v-es", "audio/mp4", "application/octet-stream", "video/mp4"),
                    "wav" => array("audio/wav", "audio/x-wav", "audio/wave", "audio/x-pn-wav", "application/octet-stream"),
                    "mov" => array("video/quicktime", "video/x-quicktime", "image/mov", "audio/aiff", "audio/x-midi", "audio/x-wav", "video/avi", "application/octet-stream"),
                    "avi" => array("video/avi", "video/msvideo", "video/x-msvideo", "image/avi", "video/xmpg2", "application/x-troff-msvideo", "audio/aiff", "audio/avi", "application/octet-stream")
                );

                $name = "allow_uploads_mime_type";
                $content = $this->_encode($mime_type);
                $insert_options = "INSERT INTO filemanager_options (option_name, option_content) VALUES ('$name' , '$content')";
                if(mysqli_query($GLOBALS["___mysqli_ston"], $insert_options))
                {
                    $core_folder = "../".ROOT_DIR_NAME."/";
                    $core_folder = realpath($core_folder);
                    $name = "base_root_folder";
                    $core_folder = base64_encode($core_folder);
                    $insert_options = "INSERT INTO filemanager_options (option_name, option_content) VALUES ('$name' , '$core_folder')";
                    if(mysqli_query($GLOBALS["___mysqli_ston"], $insert_options))
                    {
                        $ticket_table = "CREATE TABLE IF NOT EXISTS filemanager_tickets (
                            id INT NOT NULL AUTO_INCREMENT,
                            PRIMARY KEY(id),
                            parentId INT,
                            userId INT,
                            role VARCHAR(15),
                            subject TEXT,
                            message TEXT,
                            status VARCHAR(15),
                            adminTicket SMALLINT,
                            dateadded DATETIME
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                        if(mysqli_query($GLOBALS["___mysqli_ston"], $ticket_table))
                        {
                            $name = "settings";
                            $content = array(
                                'ticket' => 'off',
                                'share' => 'off',
                                'register' => 'off',
                                'admin_notification' => 'off',
                                'user_notification' => 'off'
                            );
                            $content = $this->_encode($content);
                            $insert_options = "INSERT INTO filemanager_options (option_name, option_content) VALUES ('$name' , '$content')";
                            if(mysqli_query($GLOBALS["___mysqli_ston"], $insert_options))
                            {
                                $name = "register_settings";
                                $content = array(
                                    'permissions' => array(),
                                    'allow_ext' => array(),
                                    'allow_upload' => array(),
                                    'upload_limitation' => 1,
                                    'size_limitation' => 5,
                                    'users_dir' => ''
                                );
                                $content = $this->_encode($content);
                                $insert_options = "INSERT INTO filemanager_options (option_name, option_content) VALUES ('$name' , '$content')";
                                if(mysqli_query($GLOBALS["___mysqli_ston"], $insert_options))
                                {
                                    if(!$this->install_flag)
                                    {
                                        echo '<div class="alert alert-success" style="text-align: center; font-weight: bold;">';
                                        echo "DONE: Your system has been updated to new version.";
                                        echo '</div>';
                                    }
                                }
                                else
                                {
                                    $this->show_error();
                                }
                            }
                            else
                            {
                                $this->show_error();
                            }
                        }
                        else
                        {
                            $this->show_error();
                        }
                    }
                    else
                    {
                        $this->show_error();
                    }
                }
                else
                {
                    $this->show_error();
                }
            }
            else
            {
                $this->show_error();
            }
        }
        else
        {
            $this->show_error();
        }
    }

    private function show_error()
    {
        echo '<div class="alert alert-danger" style="text-align: center; font-weight: bold;">';
        echo "ERROR: ".((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
        echo '</div>';
    }
}
if(!isset($_POST["install"]))
{
?>
<html>
    <head>
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../filemanager_css/x3.panel.css?v=<?php echo X3Config::$config["x3_panel_version"]; ?>" rel="stylesheet" />
    </head>
    <body>No.
<?php
        //$update = new UPDATE_V_2_0_0();
        //$update->update();
?>
    </body>
</html>
<?php
}
?>
