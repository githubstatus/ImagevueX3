<?php
if(session_id() == '')
{
    session_start();
}

ini_set( 'error_reporting', E_ALL ^ E_DEPRECATED );
error_reporting( E_ALL ^ E_DEPRECATED );
ini_set('log_errors',TRUE);
ini_set('html_errors',FALSE);
ini_set('error_log','filemanager_error_log.txt');
ini_set('display_errors',FALSE);

require_once 'config.php';
require_once 'filemanager_assets/JSON.php';
if(!isset($language)) {
    require_once 'filemanager_language_user.php';
}
require_once 'X3.php';

class filemanager_user_core extends Services_JSON
{
    var $db;
    public $user_username;
    public $user_firstname;
    public $user_lastname;
    public $user_email;
    public $user_id;
    public $user_dir;
    public $user_folder_name;
    public $user_root_folder;
    public $is_block = 0;
    public $pageCount = 1;
    public $start;
    public $end;
    public $user_menu;
    public $user_permissions;
    public $user_limitation;
    public $user_can = "";
    public $global_user_can = array();
    public $user_can_edit_file = false;
    public $user_can_edit_image = false;
    public $user_can_folder = "";
    public $user_can_file = "";
    public $user_can_unzip = "";
    public $role;
    public $user_no_limit;
    public $user_add_slashes;

    public $db_use;
    public $token = "";

    private $secret1 = "*-p";
    private $secret2 = "a#";


    public $use = false;

    function __construct(){
        if( $this->is_db() ) {
            $this->db = @($GLOBALS["___mysqli_ston"] = mysqli_connect(DB_HOST, DB_USER, DB_PASS));
            @((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . constant('DB_NAME')));
        }
    }

    // is basedir?
    public function is_basedir(){
        $basedir_str = @ini_get('open_basedir');
        return !empty($basedir_str);
    }

    public function touchme_error(){
			return '{ "error": "Oops, can\'t write to /content" }';
		}

		public function touchme(){
			$file = '../../content';
			if(touch($file)) {
			  $success = true;
			} else {
			  $success = false;
			}
			return $success;
    }

    // Return first image in directory
    public function first_image($dir){
    	$files = glob($dir."/*.*", GLOB_NOSORT);
    	$images = array_filter($files, function($val){
    		return in_array(strtolower(pathinfo($val, PATHINFO_EXTENSION)), array('jpg','jpeg','png','svg','gif'));
    	});
    	return basename(end($images));
  	}

    public function is_db( )
    {
        $this->db_use = true;
        if( defined( "USERNAME" ) and defined( "PASSWORD" ) ) {
            if( USERNAME != "" and PASSWORD != md5( "" ) and PASSWORD != "" ) {
                $this->db_use = false;
            }
        }
        return $this->db_use;
    }

    private function check_none_db_user( $username, $password )
    {
        if( !$this->db_use ) {
            if( defined( "USERNAME" ) and defined( "PASSWORD" ) ) {
                if( USERNAME != "" and PASSWORD != md5( "" ) and PASSWORD != "" ) {
                    global $users;
                    if( isset($users[$username]) ) {
                        if( $users[$username]["password"] == $password ) {
                            $this->role = "user";
                            $_SESSION['filemanager_user'] = md5( $username );
                            return true;
                        }
                    }
                    if( USERNAME == $username and PASSWORD == $password ) {
                        $this->role = "admin";
                        $_SESSION['filemanager_admin'] = md5( $username );
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function create_none_db_auth_token( $username, $password )
    {
        $_SESSION["lift_filemanager_token"] = md5( time() . uniqid() . $username . $this->role );
        $_SESSION["lift_filemanager_auth"] = $this->encode_this_session( $username.$this->secret1.$password.$this->secret2.$this->role );
        if( $this->role == "user" ) {
            $_SESSION["WHO_IS_IT_USER"] = $this->encode_this_session( $username );
        }
    }

    private function remove_none_db_auth_token()
    {
        unset( $_SESSION["lift_filemanager_token"] );
        unset( $_SESSION["lift_filemanager_auth"] );
        unset( $_SESSION["WHO_IS_IT_USER"] );
        unset( $_SESSION["filemanager_admin"] );
        unset( $_SESSION["filemanager_user"] );
    }

    private function check_none_db_auth_token( )
    {
        if(isset($_SESSION['filemanager_admin'])) {
            $this->role = "admin";
        }
        else if( isset( $_SESSION["filemanager_user"] ) ){
            $this->role = "user";
        }
        else {
            $this->role = "ERROR";
        }
        if( isset( $_SESSION["lift_filemanager_token"] ) and isset( $_SESSION["lift_filemanager_auth"] ) ) {
            if( isset( $_SESSION["WHO_IS_IT_USER"] ) ) {
                global $users;
                $username = $this->decode_this_session( $_SESSION["WHO_IS_IT_USER"] );
                if( isset( $users[$username]) ) {
                    $auth = $username.$this->secret1.$users[$username]["password"].$this->secret2.$this->role;
                    if( $auth == $this->decode_this_session( $_SESSION["lift_filemanager_auth"] ) ) {
                        return true;
                    }
                }
            }

        }
        return false;
    }

    private function encode_this_session( $txt )
    {
        //return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(SECRET_KEY), $txt, MCRYPT_MODE_CBC, md5(md5(SECRET_KEY))));
        if(extension_loaded('openssl')){
    			$iv = substr(hash('sha256', SECRET_KEY), 0, 16);
    			return rtrim(openssl_encrypt($txt, 'AES-256-CBC', SECRET_KEY, 0, $iv));
    		} else {
    			return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(SECRET_KEY), $txt, MCRYPT_MODE_CBC, md5(md5(SECRET_KEY))));
    		}
    }

    private function decode_this_session( $txt )
    {
        //return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(SECRET_KEY), base64_decode( $txt ), MCRYPT_MODE_CBC, md5(md5(SECRET_KEY))), "\0");
    		if(extension_loaded('openssl')){
    			$iv = substr(hash('sha256', SECRET_KEY), 0, 16);
					return rtrim(openssl_decrypt($txt, 'AES-256-CBC', SECRET_KEY, 0, $iv));
    		} else {
    			return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(SECRET_KEY), base64_decode( $txt ), MCRYPT_MODE_CBC, md5(md5(SECRET_KEY))), "\0");
    		}
    }

    protected function encode_me($txt)
    {
        $txt = strip_tags($txt);
        $txt = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $txt) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $txt = urlencode($txt);
        return $txt;
    }

    protected function decode_me($txt)
    {
        $txt = urldecode($txt);
        $txt = stripslashes($txt);
        return $txt;
    }

    private function check_ticket_status()
    {
        $settings = $this->get_option("settings");
        if($settings->ticket == "on")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_username( $args = "username" )
    {
        global $users;
        $username = $this->decode_this_session( $_SESSION["WHO_IS_IT_USER"] );
        if( isset( $users[$username] ) ) {
            if( $args == "username" ) {
                return $username;
            }
            else {
                if( isset( $users[$username][$args] ) and $args != "password" ) {
                    return $users[$username][$args];
                }
            }
        }
        return false;
    }

    public function create_user_panel($user_id)
    {
        $settings_menu = "";
        if( $this->db_use ) {
            $this->user_permissions = $this->get_option("permission_for_".$user_id);
            $display_ticket = "";
            if(!$this->check_ticket_status())
            {
                $display_ticket = 'style="display: none;"';
            }
            if( in_array( "edit_settings", $this->user_permissions ) ) {
                $settings_menu = '<li id="setting"><a href="#">Settings</a></li>';
            }
        }
        else {
            $this->user_permissions = $this->get_username( "permissions" );
            $display_ticket = 'style="display: none;"';
        }
        if(in_array("edit_profile", $this->user_permissions))
        {
            $this->user_menu = '<li id="fileManager"><a href="#">'.language_filter("File Manager", true).'</a></li>
                                '.$settings_menu.'
                                <li id="tickets" '.$display_ticket.'><a href="#" onclick="show_what = \'all\'; ticket_page = 1;">'. language_filter("Tickets", true).'</a></li>
                                <li id="editProfile"><a href="#">'.language_filter("Edit Profile", true).'</a></li>
                                <li><a href="logout.php">'.language_filter("Logout", true).'</a></li>';
        }
        else
        {
            $this->user_menu = '<li id="fileManager"><a href="#">'.language_filter("File Manager", true).'</a></li>
                                '.$settings_menu.'
                                <li id="tickets" '.$display_ticket.'><a href="#" onclick="show_what = \'all\'; ticket_page = 1;">'. language_filter("Tickets", true).'</a></li>
                                <li><a href="logout.php">'.language_filter("Logout", true).'</a></li>';
        }
        if(in_array("create_folder", $this->user_permissions))
        {
            //$this->global_user_can .= '<button class="btn btn-primary btn-group-filemanager" data-toggle="modal" data-target="#newFolder">'.language_filter("New Folder", true).'</button>';
            $this->global_user_can["create_folder"] = true;
        }
        if(in_array("copy_folders", $this->user_permissions))
        {
            $this->user_can .= '<button class="btn btn-default btn-group-filemanager" onclick="if(selected.length){container_id_tree3.html(\'<div class=\\\'alert alert-info\\\'><center><b>'.language_filter("Choose your target directory.", true, true).'</b></center></div>\'); x3_modal_copy_selected.modal(\'show\');}">'.language_filter("Copy", true).'</button>';
            $this->user_can_folder .= 'x3_conf_button.html(x3_conf_button.html()+\'<button class="btn btn-info" onclick=\"copy_dir(\\\'\'+name+\'\\\', \\\'\'+index+\'\\\',\\\'first\\\')">'.language_filter("Copy", true, true).'</button>\');';
            $this->user_can_file .= 'x3_conf_button.html(x3_conf_button.html()+\'<button class="btn btn-info" onclick="copy_file(\\\'\'+name+\'\\\', \\\'\'+index+\'\\\',\\\'first\\\')">'.language_filter("Copy", true, true).'</button>\');';
            $this->global_user_can["copy_folders"] = true;
        }
        if(in_array("move_folders", $this->user_permissions))
        {
            $this->user_can .= '<button class="btn btn-default btn-group-filemanager" onclick="if(selected.length){container_id_tree2.html(\'<div class=\\\'alert alert-info\\\'><center><b>'.language_filter("Choose your target directory.", true, true).'</b></center></div>\'); x3_modal_move_selected.modal(\'show\');}">'.language_filter("Move", true).'</button>';
            $this->user_can_folder .= 'x3_conf_button.html(x3_conf_button.html()+\'<button class="btn btn-primary" onclick="rename_dir(\\\'\'+name+\'\\\', \\\'\'+index+\'\\\',\\\'move\\\')">'.language_filter("Move", true, true).'</button>\');';
            $this->user_can_file .= 'x3_conf_button.html(x3_conf_button.html()+\'<button class="btn btn-primary" onclick="rename_file(\\\'\'+name+\'\\\', \\\'\'+index+\'\\\',\\\'move\\\')">'.language_filter("Move", true, true).'</button>\');';
            $this->global_user_can["move_folders"] = true;
        }
        if(in_array("remove_folders", $this->user_permissions))
        {
            $this->user_can .= "<button class=\"btn btn-default btn-group-filemanager\" onclick=\"if(selected.length){x3_modal_remove_selected.modal('show');}\">".language_filter("Remove", true)."</button>";
            $this->user_can_folder .= 'x3_conf_button.html(x3_conf_button.html()+\'<button class="btn btn-danger" onclick="remove_dir(\\\'\'+name+\'\\\', \\\'\'+index+\'\\\',\\\'first\\\')">'.language_filter("Remove", true, true).'</button>\');';
            $this->user_can_file .= 'x3_conf_button.html(x3_conf_button.html()+\'<button class="btn btn-danger" onclick="remove_file(\\\'\'+name+\'\\\', \\\'\'+index+\'\\\',\\\'first\\\')">'.language_filter("Remove", true, true).'</button>\');';
            $this->global_user_can["remove_folders"] = true;
        }
        if(in_array("zip_folders", $this->user_permissions))
        {
            $this->user_can .= "<button class=\"btn btn-default btn-group-filemanager\" onclick=\"if(selected.length){x3_modal_new_zip_file.modal('show');}\">".language_filter("Zip", true)."</button>";
        }
        if(in_array("upload_folders", $this->user_permissions))
        {
            //$this->global_user_can .= "<button type=\"button\" class=\"btn btn-primary btn-group-filemanager\" data-toggle=\"modal\" data-target=\"#uploader\" onclick=\"showUploader()\">".language_filter("Upload", true)."</button>";
            $this->global_user_can["upload_folders"] = true;
        }
        /*if(in_array("backup_folders", $this->user_permissions))
        {
            $this->user_can .= "<button class=\"btn btn-default btn-group-filemanager\" onclick=\"if(selected == '' || selected == null) alert('".language_filter("Please select files and folders", true, true)."'); else $('#newbackupFile').modal('show');\">".language_filter("Backup", true)."</button>";
        }*/
        if(in_array("rename_folder", $this->user_permissions))
        {
            $this->user_can_folder .= 'x3_conf_button.html(x3_conf_button.html()+\'<button class="btn btn-warning" onclick="rename_dir(\\\'\'+name+\'\\\', \\\'\'+index+\'\\\',\\\'first\\\')">'.language_filter("Rename", true, true).'</button>\');';
            $this->user_can_file .= 'x3_conf_button.html(x3_conf_button.html()+\'<button class="btn btn-warning" onclick="rename_file(\\\'\'+name+\'\\\', \\\'\'+index+\'\\\',\\\'first\\\')">'.language_filter("Rename", true, true).'</button>\');';
            $this->global_user_can["rename_folder"] = true;
        }
        if(in_array("unzip_files", $this->user_permissions))
        {
            $this->user_can_unzip .= 'x3_conf_button.html(x3_conf_button.html()+\'<button class="btn btn-inverse" onclick="unZip(\\\'\'+name+\'\\\', \\\'\'+index+\'\\\',\\\'first\\\');">'.language_filter("Unzip", true, true).'</button>\');';
        }
        if(in_array("edit_files", $this->user_permissions))
        {
            $this->user_can_edit_file = true;
        }
        /*if(in_array("edit_img", $this->user_permissions))
        {
            $this->user_can_edit_image = true;
        }*/
    }

    function get_option($name)
    {
        $content = array();
        if( $this->db_use ) {
            $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM filemanager_options WHERE option_name='$name'");
            while($row = mysqli_fetch_array($select))
            {
                $content = $this->decode($row["option_content"]);
            }
        }
        return $content;
    }

    public function isLogin()
    {
        if(isset($_SESSION['filemanager_user']))
        {
            if( $this->db_use ) {
                $ck_id = $_SESSION['filemanager_user'];
                $id = $_SESSION["filemanager_who_is_it"];
                $query = "SELECT id, is_login, ck_id FROM filemanager_users WHERE is_login='1' AND ck_id='$ck_id' AND id='$id' LIMIT 1";
                if($select = mysqli_query($GLOBALS["___mysqli_ston"], $query))
                {
                    $result = mysqli_fetch_array($select,  MYSQLI_ASSOC);
                    if($result["ck_id"] == $ck_id and $result["is_login"] == "1" and $result["id"] == $id)
                    {
                        $this->role = "user";
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
            else {
                return $this->check_none_db_auth_token();
            }
        }
        else
        {
            return false;
        }
    }

    public function login($username,$password)
    {
        $password = md5($password);
        $return["status"] = false;
        $return["msg"] = "";
        if( $this->db_use ) {
            $username = $this->encode_me($username);
            $select_query = "SELECT id,is_login,email,username,password,luck_count,luck_time,activation_key FROM  filemanager_users WHERE username='$username' OR email='$username'";
            if($select = mysqli_query($GLOBALS["___mysqli_ston"], $select_query))
            {
                $username = $this->decode_me($username);
                while ($result = mysqli_fetch_array($select))
                {
                    if($result["luck_count"] >= 4)
                    {
                        $check_luck = $this->check_luck_login($result["id"], $result["luck_time"]);
                        if($check_luck)
                        {
                            $return["msg"] = "blocked";
                            return $return;
                        }
                    }
                    if(($this->decode_me($result["username"]) == $username or $this->decode_me($result["email"]) == $username) and $result["password"] == $password)
                    {
                        if($result["activation_key"] == '' or $result["activation_key"] == NULL)
                        {
                            $login = true;
                            $id = $result["id"];
                            $date = date("YmdHis");
                            $ck_id = md5($username.$id.rand());
                            $_SESSION["filemanager_user"] = $ck_id;
                            $_SESSION["filemanager_who_is_it"] = $id;
                            $username = $this->encode_me($username);
                            $update_query = "UPDATE filemanager_users SET is_login='1', luck_count=0, ck_id='$ck_id' WHERE (username='$username' OR email='$username') AND id='$id'";
                            if(mysqli_query($GLOBALS["___mysqli_ston"], $update_query))
                            {
                                $return["status"] = true;
                            }
                            else
                            {
                                $return["msg"] = "check";
                            }
                        }
                        else
                        {
                            $return["msg"] = "check";
                        }
                    }
                    else
                    {
                        if(($this->decode_me($result["username"]) == $username or $this->decode_me($result["email"]) == $username) and $result["password"] != $password)
                        {
                            $check_luck = $this->luck_this_user($result["id"], $result["luck_count"]);
                            if($check_luck)
                            {
                                $return["msg"] = "blocked";
                                return $return;
                            }
                        }
                        $login = false;
                    }
                }
                if(@$login != true)
                {
                    $return["msg"] = "check";
                }
            }
            else
            {
                $return["msg"] = "check";
            }
        }
        else {
            if( $this->check_none_db_user( $username, $password ) ) {
                $this->create_none_db_auth_token( $username, $password );
                $return["status"] = true;
            }
            else {
                $return["msg"] = "check";
            }
        }
        return $return;
    }

    private function check_luck_login($id, $time)
    {
        $time = date_parse($time);
        $now = date_parse(date("YmdHis"));
        if($time["year"] == $now["year"] and $time["month"] == $now["month"] and $time["day"] == $now["day"] and $time["hour"] == $now["hour"])
        {
            if($time["minute"] + 5 > $now["minute"])
            {
                return true;
            }
        }
        return false;
    }
    private function luck_this_user($id, $count)
    {
        if($count == "" or $count == null)
        {
            $count = 0;
        }
        if($count < 4)
        {
            $count++;
            $date = date("YmdHis");
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_users SET luck_count='$count', luck_time='$date' WHERE id='$id'");
            return false;
        }
        else
        {
            return true;
        }
    }

    public function logout()
    {
        if( $this->db_use ) {
            $check_id = $_SESSION["filemanager_user"];
            $id = $_SESSION["filemanager_who_is_it"];
            $select_query = "SELECT id, is_login, ck_id FROM filemanager_users WHERE is_login='1' AND ck_id='$check_id' AND id='$id'";
            if($select = mysqli_query($GLOBALS["___mysqli_ston"], $select_query))
            {
                while ($result = mysqli_fetch_array($select))
                {
                    if($result["is_login"] == "1" and $result["ck_id"] == $check_id and $result["id"] == $id)
                    {
                        $date = date("YmdHis");
                        $update_query = "UPDATE filemanager_users SET is_login='0', ck_id='' WHERE ck_id='$check_id' AND id='$id'";
                        if(mysqli_query($GLOBALS["___mysqli_ston"], $update_query))
                        {
                            unset($_SESSION["filemanager_user"]);
                            unset($_SESSION["filemanager_who_is_it"]);
                            $loggout = true;
                            return $loggout;
                        }
                        else
                        {
                            $loggout = false;
                            return $loggout;
                        }
                    }
                    else
                    {
                        $loggout = false;
                    }
                }
                if(@$loggout != true)
                {
                    return $loggout;
                }
            }
            else
            {
                return false;
            }
        }
        else {
            $this->remove_none_db_auth_token();
            return true;
        }
        return false;
    }

    // new X3 mailer
    private function x3_mailer($to, $subject, $message){

        // initiate X3 PHPMailer router
        require '../app/x3.mail.inc.php';
        $use_smtp = defined('IS_SMTP_USE') && IS_SMTP_USE ? true : false;
        $phpMailer = x3_mail($use_smtp);

        // smtp
        if($use_smtp){
            $phpMailer->isSMTP();
            $phpMailer->SMTPAuth = SMTPAuth;
            $phpMailer->SMTPSecure = SMTPSecure;
            $phpMailer->Host = SMTPHost;
            $phpMailer->Port = SMTPPort;
            $phpMailer->Username = SMTPUsername;
            $phpMailer->Password = SMTPPassword;
        }

        // phpmailer
        $phpMailer->CharSet = 'UTF-8';
        $from = constant('SMTPFrom');
        if(!empty($from)) $phpMailer->setFrom($from);
        $phpMailer->addAddress($to);
        $phpMailer->Subject = $subject;
        $phpMailer->IsHTML(true);
        $phpMailer->Body = $message;
        return $phpMailer->send() ? true : false;
    }

    public function forgotPassword($email)
    {
        $result["status"] = false;
        $result["msg"] = "Forgot_Pass_Error_1";
        $check = $this->encode_me($email);
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, firstname, lastname, email, password, activation_key FROM filemanager_users WHERE email='$check'");
        $num = mysqli_num_rows($select);
        if($num > 0)
        {
            while($row = mysqli_fetch_array($select))
            {
                if($row["activation_key"] == '' or $row['activation_key'] == NULL)
                {
                    if($row["email"] == $check)
                    {
                        $newPass = substr($row["password"], 1, 6);
                        $newPass = $newPass.rand();
                        $newPass_save = md5($newPass);
                        $id = $row["id"];
                        $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_users SET password='$newPass_save' WHERE id='$id'");
                        if($update)
                        {
                            $to = $email;
                            $subject = "Forgot Password";
                            $firstname = $this->decode_me($row["firstname"]);
                            $lastname = $this->decode_me($row["lastname"]);
                            $fullname = $this->decode_me($firstname." ".$lastname);
                            $filename = basename($_SERVER["PHP_SELF"]);
                            $this_file_path = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                            $link = str_replace($filename, "", $this_file_path);

                            $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https' : 'http';
                            preg_match("/^(".$protocol.":\/\/www\.)?([^\/]+)/i",
                                $_SERVER['SERVER_NAME'], $matches);
                            $host = $matches[2];
                            preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

                            $host = "noreply@".$host;
                            $link = $protocol."://".$link;

                            //$headers = "From: " . $host . "\r\n";
                            //$headers .= "MIME-Version: 1.0\r\n";
                            //$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                            $message = "Hi ".$fullname.",<br><br>Your new password: ".$newPass."<br><br><a href=\"".$link."\">click here</a> to log in.";

                            if($this->x3_mailer($to, $subject, $message)){
                            	$result["status"] = true;
                              $result["msg"] = "done";
                            } else {
                            	$result["msg"] = "Forgot_Pass_Error_3";
                            }
                        }
                        else
                        {
                            $result["msg"] = "Forgot_Pass_Error_2";
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function userInfo()
    {
        if(isset($_SESSION["filemanager_user"]))
        {
            if( $this->db_use ) {
                $ck_id = $_SESSION["filemanager_user"];
                $id = $_SESSION["filemanager_who_is_it"];
                $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM filemanager_users WHERE is_login='1' AND ck_id='$ck_id' AND id='$id'");
                while ($row = mysqli_fetch_array($query))
                {
                    if($row["ck_id"] == $ck_id and $row["id"] == $id)
                    {
                        $this->user_username = $this->decode_me($row["username"]);
                        $this->user_firstname = $this->decode_me($row["firstname"]);
                        $this->user_lastname = $this->decode_me($row["lastname"]);
                        $this->user_email = $this->decode_me($row["email"]);
                        $this->user_id = $row["id"];
                        $this->is_block = $row["is_block"];
                        $add_slashes = substr_count(ROOT_DIR_NAME, "../");
                        $addSlashes = "../";
                        /*for( $i = 0; $i < $add_slashes; $i++) {
                            $addSlashes .= "../";
                        }*/
                        $this->user_add_slashes = $addSlashes;
                        $this->user_dir = $addSlashes.$this->decode_me($row["dir_path"]);
                        $limitation = $this->get_option("user_limit_".$row["id"]);
                        $this->user_no_limit = $limitation;
                        $limitation = ($limitation * 1024) * 1024;
                        $this->user_limitation = $this->set_limitation($this->user_dir, $limitation);
                        $this->user_folder_name = explode("/", $this->user_dir);
                        for($i = 0; $i < count($this->user_folder_name) - 2; $i++)
                        {
                            $this->user_root_folder .= $this->user_folder_name[$i]."/";
                        }
                        @$this->user_folder_name = $this->user_folder_name[count($this->user_folder_name) - 2];
                        if(substr($this->user_dir, -1) == '/') {
                            $this->user_dir = substr($this->user_dir, 0, -1);
                        }
                    }
                }
            }
            else {
                $username = $this->get_username();
                global $users;
                $this->user_username = $username;
                $this->user_firstname = $users[$username]["firstname"];
                $this->user_lastname = $users[$username]["lastname"];
                $this->user_email = $users[$username]["email"];
                $id = array_search($username, array_keys($users));
                $this->user_id = $id;
                $this->is_block = $users[$username]["is_block"];
                $add_slashes = substr_count(ROOT_DIR_NAME, "../");
                $addSlashes = "../";
                $this->user_add_slashes = $addSlashes;
                $this->user_dir = $addSlashes.$users[$username]["dir_path"];
                $limitation = $users[$username]["limitation"];
                if( $limitation == 0 ) $limitation = 1000000;
                $this->user_no_limit = $limitation;
                $limitation = ($limitation * 1024) * 1024;
                $this->user_limitation = $this->set_limitation($this->user_dir, $limitation);
                $this->user_folder_name = explode("/", $this->user_dir);
                for($i = 0; $i < count($this->user_folder_name) - 2; $i++)
                {
                    $this->user_root_folder .= $this->user_folder_name[$i]."/";
                }
                @$this->user_folder_name = $this->user_folder_name[count($this->user_folder_name) - 2];
                if(substr($this->user_dir, -1) == '/') {
                    $this->user_dir = substr($this->user_dir, 0, -1);
                }
            }
        }
    }
    private function set_limitation($directory, $limitation)
    {
        $size = 0;
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file)
        {
            $size += $file->getSize();
        }
        $limit = ($size / $limitation) * 100;
        return $limit;
    }

    public function get_mime_type()
    {
        /*$content = array();
        $select = mysql_query("SELECT * FROM filemanager_options WHERE option_name='allow_uploads_mime_type'");
        while($row = mysql_fetch_array($select))
        {
            if($row["option_name"] == "allow_uploads_mime_type")
            {
                $content = $this->decode($row["option_content"]);
            }
        }

        return $content;*/
        global $MIME_TYPES;
        return $MIME_TYPES;
    }

    public function editProfile($id, $username, $firstname, $lastname, $email)
    {
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM filemanager_users WHERE (username='$username' OR email='$email') AND id<>'$id'");
        $num = mysqli_num_rows($select);
        if($num > 0)
        {
            echo "null";
            exit;
        }

        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM filemanager_db WHERE username='$username' OR email='$email'");
        $num = mysqli_num_rows($select);
        if($num > 0)
        {
            echo "null";
            exit;
        }

        if($this->isLogin())
        {
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_users SET username='$username', firstname='$firstname', lastname='$lastname', email='$email' WHERE id='$id'");
            if($update)
            {
                echo 'true';
            }
            else
            {
                echo 'false';
            }
        }
        else
        {
            echo 'false';
        }
    }

    public function editPassword($id, $user_newPass)
    {
        if($this->isLogin())
        {
            $new = md5($user_newPass);
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_users SET password='$new' WHERE id='$id'");
            if ($update)
            {
                echo 'true';
            }
            else
            {
                echo 'false';
            }
        }
        else
        {
            echo 'false';
        }
    }

    public function user_can_do_it($id, $work, $limit = "")
    {
        if($limit != "")
        {
            if($limit > 100)
            {
                return false;
            }
        }
        if( $this->db_use ) {
            $perms = $this->get_option("permission_for_".$id);
        }
        else {
            $perms = $this->get_username( "permissions" );
        }
        if(in_array($work, $perms))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function recursiveDelete($directory)
    {
        // if the path is not valid or is not a directory ...
        if(!file_exists($directory) || !is_dir($directory))
        {
            return false;
        }
        elseif(!is_readable($directory))// ... if the path is not readable
        {
            return false;
        }
        else // ... else if the path is readable
        {
            // open the directory
            $handle = opendir($directory);

            // and scan through the items inside
            while (false !== ($item = readdir($handle)))
            {
                // if the filepointer is not the current directory
                // or the parent directory
                if($item != '.' && $item != '..')
                {
                    // we build the new path to delete
                    $path = $directory.'/'.$item;

                    // if the new path is a directory
                    if(is_dir($path))
                    {
                        // we call this function with the new path
                        self::recursiveDelete($path);
                    }
                    else // if the new path is a file
                    {
                        // remove the file
                        if(!is_writable($path))
                        {
                            @chmod($path, 0644);
                        }
                        @unlink($path);
                    }
                }
            }

            // close the directory
            closedir($handle);

            // try to delete the now empty directory
            if(@!rmdir($directory))
            {
                return false;
            }

            return true;
        }
    }

    public function copy_directory( $source, $destination, $check = false )
    {
        if ( is_dir( $source ) )
        {
            @mkdir( $destination );
            $directory = dir( $source );
            while ( FALSE !== ( $readdirectory = $directory->read() ) )
            {
                if ( $readdirectory == '.' || $readdirectory == '..' )
                {
                    continue;
                }
                $PathDir = $source . '/' . $readdirectory;
                if ( is_dir( $PathDir ) )
                {
                    self::copy_directory( $PathDir, $destination . '/' . $readdirectory );
                    continue;
                }

                $flag = false;
                if(!is_writable($PathDir))
                {
                    $flag = true;
                    chmod($PathDir, 0644);
                }
                copy( $PathDir, $destination . '/' . $readdirectory );
                if($flag)
                {
                    $flag = false;
                    chmod($PathDir, 0444);
                    chmod($destination . '/' . $readdirectory, 0444);
                }
            }
            $directory->close();
        }
        else
        {
            $flag = false;
            if(!is_writable($source))
            {
                $flag = true;
                chmod($source, 0644);
            }
            copy( $source, $destination );
            if($flag)
            {
                $flag = false;
                chmod($source, 0444);
                chmod($destination, 0444);
            }
        }
    }

    public function rename_directory($oldName, $newName)
    {
        if(is_dir($newName))
        {
            return false;
        }

        if(mkdir($newName))
        {
            $this->copy_directory($oldName, $newName);
            if(is_dir($newName))
            {
                $delete_old_dir = $this->recursiveDelete($oldName);
                if(is_dir($oldName))
                {
                    @chmod($oldName, 777);
                    rmdir($oldName);
                }

                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function create_zip($folderName,$zipFileName)
    {
        $zip = new ZipArchive();
        if(is_dir($folderName))
        {
            $zip_archive = $zip->open($zipFileName.".zip",ZIPARCHIVE::CREATE);
            if($zip_archive === true)
            {
                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderName));
                foreach ($iterator as $key => $value)
                {
                    $check = substr($key, -2);
                    if( $check != ".." and $check != "/." ) {
                        $_key = str_replace("../", "", $key);
                        $_key = str_replace("./", "", $_key);
                        @$zip->addFile(realpath($key), $_key);
                    }
                }
                $zip->close();
                if(file_exists($zipFileName.".zip"))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            return false;
        }
    }

    public function extract_zip($zipFileName,$pasteLocation)
    {
        if(!is_dir($pasteLocation))
        {
            mkdir($pasteLocation);
        }
        $zip = new ZipArchive();
        if ($zip->open($zipFileName) === TRUE)
        {
            for($i = 0; $i < $zip->numFiles; $i++)
            {
                $zip->extractTo($pasteLocation, array($zip->getNameIndex($i)));
            }
            $zip->close();
            if(is_dir($pasteLocation) or is_file($pasteLocation))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function get_base_root()
    {
        $this->userInfo();
        return realpath($this->user_dir);
    }

    public function check_base_root($newName, $search = false)
    {
        $check_address = explode("/", $newName);
        if(!$search)
        {
            $count = count($check_address);
            for($i = 0; $i < $count; $i++)
            {
                if($i == $count - 1)
                {
                    unset($check_address[$i]);
                    break;
                }
            }
        }
        $check_address = implode("/", $check_address);

        if($check_address == "..")
        {
            $check_address = ROOT_DIR_NAME;
        }

        $check_address = realpath($check_address);
        $check_root = $this->get_base_root();
        if(strpos($check_address, $check_root) === FALSE)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function name_filter($name, $filemanager = false)
    {
        $newName = str_replace("...", "../", $name);
        $newName = str_replace("///", "/", $newName);
        $newName = str_replace("//", "/", $newName);
        $newName = str_replace("\\\\\\", "\\", $newName);
        $newName = str_replace("\\\\", "\\", $newName);
        if( !$filemanager ) {
            if(strpos($newName, $this->user_add_slashes.ROOT_DIR_NAME) === FALSE)
            {
                $newName = str_replace(ROOT_DIR_NAME, $this->user_add_slashes.ROOT_DIR_NAME, $newName);
            }
        }
        return $newName;
    }

    public function check_username_email_of_user($username, $email, $user_id)
    {
        $username = $this->encode_me($username);
        $email = $this->encode_me($email);
        if($user_id == 0)
        {
            $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username, email, id FROM filemanager_users WHERE username='$username' OR email='$email'");
        }
        else
        {
            $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username, email, id FROM filemanager_users WHERE (username='$username' OR email='$email') AND id<>'$user_id'");
        }
        while($row = mysqli_fetch_array($select))
        {
            if($row["username"] == $username and $row["id"] != $user_id)
            {
                echo "username";
                exit();
            }

            if($row["email"] == $email and $row["id"] != $user_id)
            {
                echo "email";
                exit();
            }
        }
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT username, email FROM filemanager_db WHERE username='$username' OR email='$email'");
        while($row = mysqli_fetch_array($select))
        {
            if($row["username"] == $username)
            {
                echo "username";
                exit();
            }

            if($row["email"] == $email)
            {
                echo "email";
                exit();
            }
        }

        echo "done";
        exit();
    }

    private function register_user_dir($dir, $username)
    {
        $filter = array("'", "\"", "\\", "/", " ", "~", "!", "@", "#", "\$", "%", "^", "&", "*", "(", ")", "-", "+", "=", "|", "{", "}", "[", "]", ",", ".", "?", "<", ">", "`");
        foreach($filter as $value)
        {
            $username = str_replace($value, "_", $username);
        }
        $new_dir = $dir.$username."/";
        if(!is_dir($new_dir))
        {
            return $new_dir;
        }
        else
        {
            $username .= rand();
            return $this->register_user_dir($dir, $username);
        }
    }

    public function register_this_user($username, $email, $firstname, $lastname)
    {
        $username = $this->encode_me($username);
        $email = $this->encode_me($email);
        $firstname = $this->encode_me($firstname);
        $lastname = $this->encode_me($lastname);
        $password = rand()."*".substr(md5($username), 1, 6);
        $email_pass = $password;
        $password = md5($password);
        $register_settings = $this->get_option("register_settings");
        $slash = "";
        if(substr($register_settings->users_dir, -1) != "/")
        {
            $slash = "/";
        }
        $user_dir = $register_settings->users_dir.$slash;
        $user_dir = $this->register_user_dir($user_dir, $username);
        $user_ext = (array) $register_settings->allow_ext;
        $user_up = (array) $register_settings->allow_upload;
        $user_perm = (array) $register_settings->permissions;
        $limitation = $register_settings->size_limitation;
        $upload_limitation = $register_settings->upload_limitation;
        $user_dir = $this->encode_me($user_dir);
        $date = date("YmdHis");
        $deny_files = array();
        $activation_code = md5($username.$email.rand());
        $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO filemanager_users (firstname, lastname, username, email, password, is_login, activation_key, is_block, dir_path, date_added) VALUES ('$firstname', '$lastname', '$username', '$email', '$password', 0, '$activation_code', 1, '$user_dir', '$date')");
        if($insert)
        {
            $user_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
            require_once 'filemanager_user/option_class.php';
            $option = new option_class();
            $name = "allow_extensions_".$user_id;
            if($option->add_option($name, $user_ext))
            {
                $name = "allow_uploads_".$user_id;
                if($option->add_option($name, $user_up))
                {
                    $name = "permission_for_".$user_id;
                    if($option->add_option($name, $user_perm))
                    {
                        $name = "deny_folders_".$user_id;
                        if($option->add_option($name, $deny_files))
                        {
                            $name = "user_limit_".$user_id;
                            if($option->add_option($name, $limitation))
                            {
                                $name = "user_upload_limit_".$user_id;
                                if($option->add_option($name, $upload_limitation))
                                {
                                    $to = $this->decode_me($email);
                                    $username = $this->decode_me($username);
                                    $subject = "Filemanager Registration";
                                    $fullname = $this->decode_me($firstname." ".$lastname);
                                    $filename = basename($_SERVER["PHP_SELF"]);
                                    $this_file_path = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                                    $link = str_replace("filemanager_admin/".$filename, "filemanager_user/", $this_file_path);

                                    $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https' : 'http';
                                    preg_match("/^(".$protocol.":\/\/www\.)?([^\/]+)/i",
                                        $_SERVER['SERVER_NAME'], $matches);
                                    $host = $matches[2];
                                    preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

                                    $host = "noreply@".$host;
                                    $link = $protocol."://".$link."?activation_code=".$activation_code."&info=".md5($user_id);

                                    //$headers = "From: " . $host . "\r\n";
                                    //$headers .= "MIME-Version: 1.0\r\n";
                                    //$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                    $message = "Hi ".$fullname."; <br> This is your File Manager <br /> username: ".$username." <br /> password: ".$email_pass." <br/> You can <a href=\"".$link."\">click here ( ".$link." )</a> to activate your account.<br> Please do not reply to this email.";

                                    if($this->x3_mailer($to, $subject, $message)){
				                            	return true;
				                            } else {
				                            	$this->delete_user($user_id);
				                              return false;
				                            }
                                }
                                else
                                {
                                    $this->delete_user($user_id);
                                    return false;
                                }
                            }
                            else
                            {
                                $this->delete_user($user_id);
                                return false;
                            }
                        }
                        else
                        {
                            $this->delete_user($user_id);
                            return false;
                        }
                    }
                    else
                    {
                        $this->delete_user($user_id);
                        return false;
                    }
                }
                else
                {
                    $this->delete_user($user_id);
                    return false;
                }
            }
            else
            {
                $this->delete_user($user_id);
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    private function delete_user($user_id)
    {
        $delete = mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM filemanager_users WHERE id='$user_id'");
        if($delete)
        {
            require_once 'filemanager_user/option_class.php';
            $option = new option_class();
            $name = "allow_extensions_".$user_id;
            $option->delete_option($name);
            $name = "allow_uploads_".$user_id;
            $option->delete_option($name);
            $name = "permission_for_".$user_id;
            $option->delete_option($name);
            $name = "deny_folders_".$user_id;
            $option->delete_option($name);
            $name = "user_limit_".$user_id;
            $option->delete_option($name);
            $name = "user_upload_limit_".$user_id;
            $option->delete_option($name);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function activate_user($key, $id)
    {
        $key = $this->encode_me($key);
        $id = $this->encode_me($id);
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, dir_path, username, activation_key FROM filemanager_users WHERE MD5(id)='$id' AND activation_key='$key'");
        $num = mysqli_num_rows($select);
        if($num <= 0)
        {
            return null;
        }

        while($row = mysqli_fetch_array($select))
        {
            if($row["activation_key"] == $key and md5($row["id"]) == $id)
            {
                $user_id = $row["id"];
                $user_dir = $this->decode_me($row["dir_path"]);
                $username = $this->decode_me($row["username"]);
                $mkdir = false;
                if(!is_dir($user_dir))
                {
                    if(@mkdir($user_dir))
                    {
                        $mkdir = true;
                    }
                }
                else
                {
                    $user_dir = explode("/", $user_dir);
                    $count = count($user_dir);
                    for($i = 0; $i < $count; $i++)
                    {
                        if($i == $count - 2)
                        {
                            unset($user_dir[$i]);
                            break;
                        }
                    }
                    $user_dir = implode("/", $user_dir)."/";
                    $user_dir = $this->register_user_dir($user_dir, $username);
                    if(@mkdir($user_dir))
                    {
                        $mkdir = true;
                    }
                }
                if($mkdir)
                {
                    $update = "UPDATE filemanager_users SET activation_key='', is_block=0 WHERE id='$user_id'";
                    if(mysqli_query($GLOBALS["___mysqli_ston"], $update))
                    {
                        return true;
                    }
                    else
                    {
                        @rmdir($user_dir);
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
        }
        return null;
    }

    public function change_date_format($date)
    {
        $_date = $date;
        $new_date = date("Y-m-d H:i:s");
        $date = date_parse($date);
        $new_date = date_parse($new_date);
        $years_ago = $new_date["year"] - $date["year"];
        if($years_ago != 0)
        {
            if($years_ago == 1)
            {
                return $years_ago." year ago";
                exit();
            }
            else
            {
                return $years_ago." years ago";
                exit();
            }
        }
        if($new_date["month"] == $date["month"] and $new_date["day"] == $date["day"] and $new_date["hour"] == $date["hour"] and $new_date["minute"] <= ($date["minute"] + 1))
        {
            return "Just now";
            exit();
        }
        $min_ago = $new_date["minute"] - $date["minute"];
        if($new_date["month"] == $date["month"] and $new_date["day"] == $date["day"] and $new_date["hour"] == $date["hour"])
        {
            return $min_ago." min ago";
            exit();
        }
        $hour_ago = $new_date["hour"] - $date["hour"];
        if($new_date["month"] == $date["month"] and $new_date["day"] == $date["day"])
        {
            if($hour_ago == 1)
            {
                return $hour_ago." hr ago";
                exit();
            }
            else
            {
                return $hour_ago." hrs ago";
                exit();
            }
        }
        $day_ago = $new_date["day"] - $date["day"];
        if($new_date["month"] == $date["month"] and $day_ago <= 10)
        {
            if($day_ago == 1)
            {
                return $day_ago." day ago";
                exit();
            }
            else
            {
                return $day_ago." days ago";
                exit();
            }
        }
        $dateModified = strtotime($_date);
        $dateModified = date("M j, Y", $dateModified);
        return $dateModified;
        exit();
    }

    public function page($page, $fullCount, $count_show)
    {
        if($count_show == "all")
        {
            $this->start = 0;
            $this->end = $fullCount;
            $this->pageCount = 1;
            return null;
        }
        $this->pageCount = self::_numpage($fullCount, $count_show);
        if($page > $this->pageCount)
        {
            $page = $this->pageCount;
        }

        if($page == 0 or $page < 0)
        {
            $page = 1;
        }

        if($page == 1 and $fullCount > $count_show)
        {
            $this->start = 0;
            $this->end = $count_show;
        }
        elseif($page == 1 and $fullCount < $count_show)

        {
            $this->start = 0;
            $this->end = $fullCount;
        }
        else
        {
            $count = $page * $count_show;
            $this->start = $count - $count_show;
            if ($fullCount < $count)
            {
                $this->end = $fullCount;
            }
            else
            {
                $this->end = $count;
            }
        }
    }

    private function _numpage($co_tot,$co)
    {
        if ($co_tot == 0)
        {
            $page = 1;
            return $page;
        }

        if($co > $co_tot)
        {
            $co_tot = $co;
            $page = $co_tot / $co;
            return $page;
        }
        else
        {
            $page = $co_tot / $co;
            if ($page > 0 and $page < 1)
            {
                $page = 2;
                return $page;
            }
            else if ($page > 1 and $page < 2)
            {
                $page = 2;
                return $page;
            }
            return ceil($page);
        }
    }

    /*public function share_files($send_to, $emails, $subject, $from, $message, $file)
    {
        require_once 'filemanager_assets/PHPMailer/class.phpmailer.php';
        $phpMailer = new PHPMailer();

        if( defined( "IS_SMTP_USE" ) )
        {
            if( IS_SMTP_USE )
            {
                $phpMailer->SMTPAuth = SMTPAuth;
                $phpMailer->SMTPSecure = SMTPSecure;
                $phpMailer->Host = SMTPHost;
                $phpMailer->Mailer = "smtp";
                $phpMailer->Port = SMTPPort;
                $phpMailer->Username = SMTPUsername;
                $phpMailer->Password = SMTPPassword;
                if( SMTPFromSMTPUsername == true ) {
                    $from = SMTPUsername;
                }
            }
        }

        $phpMailer->CharSet = 'UTF-8';
        $phpMailer->From = $from;
        $phpMailer->FromName = $from;
        $phpMailer->AddAddress($send_to);
        $phpMailer->Subject = $subject;
        $phpMailer->IsHTML(true);
        $phpMailer->Body = $message;
        $phpMailer->AddAttachment($file);
        if($phpMailer->Send())
        {
            if($emails != "")
            {
                $phpMailer->ClearAddresses();
                $emails = explode(", ", $emails);
                foreach($emails as $to)
                {
                    if($to != "")
                    {
                        $phpMailer->CharSet = 'UTF-8';
                        $phpMailer->AddAddress($to);
                        $phpMailer->Subject = $subject;
                        $phpMailer->IsHTML(true);
                        $phpMailer->Body = $message;
                        $phpMailer->AddAttachment($file);
                        $phpMailer->Send();
                        $phpMailer->ClearAddresses();
                    }
                }
            }
            echo "true";
        }
        else
        {
            echo "false";
        }
    }*/

    public function create_json_file($path)
    {
  		//$files = glob($path."/*.json");
  		//if(empty($files))
      //{

    	// optional page date
    	$data = new ArrayObject();
    	if(isset($_POST['title'])) $data['title'] = $_POST['title'];
    	if(isset($_POST['label'])) $data['label'] = $_POST['label'];
    	if(isset($_POST['link']) || isset($_POST['target'])) $data['link'] = new ArrayObject();
    	if(isset($_POST['link'])) $data['link']['url'] = $_POST['link'];
    	if(isset($_POST['target'])) $data['link']['target'] = $_POST['target'];

    	if(isset($_POST['hidden'])) $data['hidden'] = $_POST['hidden']; // <-- fix hidden

    	// create json object and write contents to page.json
    	$json = phpversion() < 5.4 ? json_encode($data) : json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    	file_put_contents($path . '/page.json', $json);

      //$fp = fopen($path."/page.json", "w");
      //fwrite($fp, "{}");
      //fclose($fp);
       //}
    }
}

class filemanager_show_from_root_user extends filemanager_user_core
{
    public $root_files_folders;
    private $root_dir = "../";
    private $ignored = array('.', '..', 'filemanager_user_core.php','config.php', 'filemanager_config.php', 'filemanager_core.php', 'filemanager_language.php', 'filemanager_language_user.php', 'filemanager_js', 'filemanager_install', 'filemanager_css', 'filemanager_backups', 'filemanager_admin', 'filemanager_img', 'filemanager_assets', 'filemanager_user', 'filemanager_temp', 'filemanager_fonts', 'filemanager_img/pattern', 'filemanager_img/fancy', 'filemanager_assets/PHPMailer', 'filemanager_assets/PHPMailer/docs', 'filemanager_assets/PHPMailer/extras', 'filemanager_assets/PHPMailer/language', 'filemanager_assets/PHPMailer/test', 'filemanager_assets/securimage', 'filemanager_assets/securimage/backgrounds', 'filemanager_assets/securimage/images', 'filemanager_assets/securimage/words', 'services', 'sitemap', 'json', 'feed', 'custom');
    private $suppurt_ext;
    private $sort;
    private $search = "";
    public $loading_this_file;
    function __construct($show_root, $path = '', $sort_with = 'date', $user_id, $search = '')
    {
        $this->sort = $sort_with;
        if( $this->is_db() ) {
            $this->suppurt_ext = $this->get_option("allow_extensions_".$user_id);
        }
        else {
            global $ALLOW_EXTENSIONS;
            $this->suppurt_ext = $ALLOW_EXTENSIONS;
        }
        $this->search = $search;
        $this->set_root_dir_folder();
        $this->check_json_file($path);
        if($show_root)
            $this->get_files_folders($path, $user_id);
        else
            $this->show_dir($path, $user_id);
    }

    private function set_root_dir_folder()
    {
        $this->root_dir .= ROOT_DIR_NAME;
    }
    private function check_json_file($path)
    {
    		if(is_dir($path)) {
    			$files = glob($path."/*.json");
    			if(empty($files) && is_writable($path))
	        {
	            $fp = fopen($path."/page.json", "w");
	            fwrite($fp, "{}");
	            fclose($fp);
	        }
    		}
    }

    public function curPageURL()
    {
        $pageURL = 'http';
        if(isset($_SERVER["HTTPS"]))
        {
            if ($_SERVER["HTTPS"] == "on")
            {
                $pageURL .= "s";
            }
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80")
        {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else
        {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    private function filter_search_str($txt)
    {
        $txt = str_replace("../", "", $txt);
        $txt = str_replace("/", "", $txt);
        //$txt = str_replace(".", "", $txt);
        return $txt;
    }

    private function find_all_files($dir, $extensions, $search)
    {
        $root = scandir($dir);
        foreach($root as $value)
        {
            if($value === '.' or $value === '..') continue;
            if(is_file($dir."/".$value))
            {
                $_ext = explode( ".", $value );
                $_ext = end( $_ext );
                $ext = strtolower( $_ext );
                if(in_array($ext, $extensions))
                {
                    $s_value = strtolower($value); //str_replace($ext, "", $value)
                    $s_search = strtolower($search);
                    if(strpos($s_value, $s_search) !== FALSE)
                    {
                        $file = $dir."/".$value;
                        $filename = str_replace("..//", "", $file);
                        $this->root_files_folders[$filename] = filemtime($file);
                    }
                }
            }
            else
            {
                $s_value = strtolower($value); //str_replace($ext, "", $value)
                $s_search = strtolower($search);
                if(strpos($s_value, $s_search) !== FALSE)
                {
                    $file = $dir."/".$value;
                    $filename = $file;//str_replace(ROOT_DIR_NAME."/", "", $file);
                    $this->root_files_folders[$filename] = filemtime($file);
                }
            }
        }
    }

    private function findFiles($directory, $extensions = array())
    {
        /* Search From User Root Dir */
        $this->userInfo();
        $directory = $this->user_dir;

        if(parent::check_base_root($directory, true))
        {
            $search = $this->filter_search_str($this->search);
            $directories = array();//"";
            function glob_recursive($directory, &$directories = array(), $search)
            {
                foreach(glob($directory, GLOB_ONLYDIR | GLOB_NOSORT) as $folder)
                {
                    $directories[] = $folder;
                    glob_recursive("{$folder}/*", $directories, $search);
                }
            }
            @glob_recursive($directory, $directories, $search);
            $files = array ();
            foreach($directories as $directory)
            {
                if($directory == "..") $directory = "../";
                $slashes = "../";
                if(strpos($directory, "..//") !== FALSE)
                {
                    $slashes = "..//";
                }
                if (in_array(str_replace($slashes, "", $directory), $this->ignored)) continue;
                $this->find_all_files($directory, $extensions, $search);
                /*foreach($extensions as $extension)
                {
                    foreach(glob("{$directory}/{$search}.{$extension}") as $file)
                    {
                        $files[$extension][] = $file;
                        $filename = str_replace("..//", "", $file);
                        $this->root_files_folders[$filename] = filemtime($file);
                    }
                }*/
            }
            @arsort($this->root_files_folders);
            if($this->sort != 'date')
            {
                @$this->root_files_folders = $this->sort_with_name($this->root_files_folders);
            }
        }
        @$this->root_files_folders = array_keys($this->root_files_folders);
    }

    public function get_files_folders($path, $user_id)
    {
        $this->root_dir = $path;
        if($this->search != '')
        {
            $this->findFiles($this->root_dir, $this->suppurt_ext);
        }
        else
        {
            $deny_folders = $this->get_option("deny_folders_".$user_id);
            foreach (scandir($this->root_dir) as $file)
            {
                if (in_array($file, $this->ignored)) continue;
                $realpath = realpath($this->root_dir . '/' . $file);
                if(in_array($realpath, $deny_folders)) continue;
                if(is_file($this->root_dir . '/' . $file))
                {
                    $ext = pathinfo($this->root_dir . '/' . $file, PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    if(!in_array($ext, $this->suppurt_ext)) continue;
                }
                $this->root_files_folders[$file] = filemtime($this->root_dir . '/' . $file);
            }
            @arsort($this->root_files_folders);

            if($this->sort != 'date')
            {
                @$this->root_files_folders = $this->sort_with_name($this->root_files_folders);
            }
            @$this->root_files_folders = array_keys($this->root_files_folders);
        }
    }

    public function formatBytes($path)
    {
        if(is_dir($path))
        {
            $bytes = $this->dirSize($path);
        }
        else
        {
            $bytes = sprintf('%u', filesize($path));
        }
        if ($bytes > 0)
        {
            $unit = intval(log($bytes, 1024));
            $units = array('B', 'KB', 'MB', 'GB');

            if (array_key_exists($unit, $units) === true)
            {
                return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
            }
        }
        else
            return $bytes;
    }
    function dirSize($directory)
    {
        $size = 0;
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
            $size+=$file->getSize();
        }
        return $size;
    }

    public function show_dir($path, $user_id)
    {
        if($this->search != '')
        {
            $this->findFiles($path, $this->suppurt_ext);
        }
        else
        {
            $deny_folders = $this->get_option("deny_folders_".$user_id);
            $mypath = is_dir($path) ? $path : array();
            foreach (scandir($mypath) as $file)
            {
                if (in_array($file, $this->ignored)) continue;
                $realpath = realpath($path . '/' . $file);
                if(in_array($realpath, $deny_folders)) continue;
                if(is_file($path . '/' . $file))
                {
                    $ext = pathinfo($path . '/' . $file, PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    if(!in_array($ext, $this->suppurt_ext)) continue;
                }
                $this->root_files_folders[$file] = filemtime($path . '/' . $file);
            }
            @arsort($this->root_files_folders);
            if($this->sort != 'date')
            {
                @$this->root_files_folders = $this->sort_with_name($this->root_files_folders);
            }
            @$this->root_files_folders = array_keys($this->root_files_folders);
        }
    }

    public function sort_with_name($array)
    {
    		$new_arr = array();
        foreach($array as $key => $value)
        {
            //$first_char = strtolower(substr($key, 0, 1));
            $new_arr[$key] = $key;
        }
        //asort($new_arr);
        natcasesort($new_arr);
        foreach($new_arr as $key => $value)
        {
            $new_arr[$key] = $array[$key];
        }
        return $new_arr;
    }
}

class editImageUser
{
    public $source;
    public $destination;
    public $width;
    public $height;
    public $thumb;
    private $array = array("jpg","jpeg","png","gif");
    private $extension;

    public function initEdit($source,$destination)
    {
        $this->source = $source;
        $this->destination = $destination;

        if(!is_file($source))
        {
            echo "Not found picture";
        }
        else
        {
            $pathinfo = pathinfo($source);
            $extension = $pathinfo['extension'];
            $this->extension = strtolower($extension);

            if(!in_array($this->extension,$this->array))
            {
                echo "File not picture is $extension";
            }
            else
            {
                list($wid,$hei) = getimagesize($source);
                $this->width = $wid;
                $this->height = $hei;
                $this->resize($wid,$hei);
            }
        }
    }

    public function resize($newWidth,$newHeight)
    {
        $this->thumb = imagecreatetruecolor($newWidth,$newHeight);
        if($this->extension == 'jpg' or $this->extension == 'jpeg')
        {
            $source = imagecreatefromjpeg($this->source);
            imagecopyresampled($this->thumb,$source,0,0,0,0,$newWidth,$newHeight,$this->width,$this->height);
            imagejpeg($this->thumb,$this->destination,100);
        }
        if($this->extension == 'png')
        {
            $source = imagecreatefrompng($this->source);
            imagecopyresampled($this->thumb,$source,0,0,0,0,$newWidth,$newHeight,$this->width,$this->height);
            imagepng($this->thumb,$this->destination,9);
        }
        if($this->extension == 'gif')
        {
            $source = imagecreatefromgif($this->source);
            imagecopyresampled($this->thumb,$source,0,0,0,0,$newWidth,$newHeight,$this->width,$this->height);
            imagegif($this->thumb,$this->destination);
        }
    }

    public function addText($x,$y,$text,$colorText,$alphaText,$rotationText,$fontFile,$fontsize)
    {

        if($this->extension == 'jpeg' or $this->extension == "jpg")
        {
            $color = imagecolorallocatealpha($this->thumb,$colorText[0],$colorText[1],$colorText[2],$alphaText);
            imagettftext($this->thumb,$fontsize,$rotationText,$x,$y + 19,$color,$fontFile,$text);
            imagejpeg($this->thumb,$this->destination,100);
        }
        if($this->extension == 'png')
        {
            $color = imagecolorallocatealpha($this->thumb,$colorText[0],$colorText[1],$colorText[2],$alphaText);
            imagettftext($this->thumb,$fontsize,$rotationText,$x,$y,$color,$fontFile,$text);
            imagepng($this->thumb,$this->destination,9);
        }
        if($this->extension == 'gif')
        {
            $color = imagecolorallocatealpha($this->thumb,$colorText[0],$colorText[1],$colorText[2],$alphaText);
            imagettftext($this->thumb,$fontsize,$rotationText,$x,$y,$color,$fontFile,$text);
            imagegif($this->thumb,$this->destination);
        }

    }

    public function shadowText($x,$y,$text,$colorText,$alphaText,$rotationText,$fontFile,$fontsize)
    {
        $this->addText($x,$y,$text,$colorText,50,$rotationText,$fontFile,$fontsize);
        $this->addText($x-3,$y-4,$text,$colorText,$alphaText,$rotationText,$fontFile,$fontsize);
    }

    public function rotation($rotation,$color)
    {
        $col = @imagecolorallocate($this->thumb,$color[0],$color[1],$color[2]);
        $rotat = @imagerotate($this->thumb,$rotation,$col,0);

        if($this->extension == 'jpeg' or $this->extension == "jpg")
        {
            imagejpeg($rotat,$this->destination,100);
        }
        if($this->extension == 'png')
        {
            imagepng($rotat,$this->destination,9);
        }
        if($this->extension == 'gif')
        {
            imagegif($rotat,$this->destination);
        }
    }

    public function filter($nameFilter)
    {
        $nameFilter = strtoupper($nameFilter);

        switch ($nameFilter)
        {
            case 'GRAYSCALE':
            {
                imagefilter($this->thumb, IMG_FILTER_GRAYSCALE);
                if($this->extension == 'jpeg' or $this->extension == "jpg")
                {
                    imagejpeg($this->thumb,$this->destination,100);
                }
                if($this->extension == 'png')
                {
                    imagepng($this->thumb,$this->destination,9);
                }
                if($this->extension == 'gif')
                {
                    imagegif($this->thumb,$this->destination);
                }

            }
                break;
            case 'NEGATIVE' :
            {
                imagefilter($this->thumb ,IMG_FILTER_NEGATE);
                if($this->extension == 'jpeg' or $this->extension == "jpg")
                {
                    imagejpeg($this->thumb,$this->destination,100);
                }
                if($this->extension == 'png')
                {
                    imagepng($this->thumb,$this->destination,9);
                }
                if($this->extension == 'gif')
                {
                    imagegif($this->thumb,$this->destination);
                }
            }
                break;
            case 'REMOVAL'  :
            {
                imagefilter($this->thumb,IMG_FILTER_MEAN_REMOVAL);
                if($this->extension == 'jpeg' or $this->extension == "jpg")
                {
                    imagejpeg($this->thumb,$this->destination,100);
                }
                if($this->extension == 'png')
                {
                    imagepng($this->thumb,$this->destination,9);
                }
                if($this->extension == 'gif')
                {
                    imagegif($this->thumb,$this->destination);
                }
            }
                break;
            case 'EMBOSS'   :
            {
                imagefilter($this->thumb,IMG_FILTER_EMBOSS);
                if($this->extension == 'jpeg' or $this->extension == "jpg")
                {
                    imagejpeg($this->thumb,$this->destination,100);
                }
                if($this->extension == 'png')
                {
                    imagepng($this->thumb,$this->destination,9);
                }
                if($this->extension == 'gif')
                {
                    imagegif($this->thumb,$this->destination);
                }
            }
                break;
            case 'BLUR'     :
            {
                imagefilter($this->thumb,IMG_FILTER_GAUSSIAN_BLUR);
                if($this->extension == 'jpeg' or $this->extension == "jpg")
                {
                    imagejpeg($this->thumb,$this->destination,100);
                }
                if($this->extension == 'png')
                {
                    imagepng($this->thumb,$this->destination,9);
                }
                if($this->extension == 'gif')
                {
                    imagegif($this->thumb,$this->destination);
                }
            }
        }
    }

    public function crop($x, $y, $width, $height)
    {
        $this->thumb = imagecreatetruecolor($width,$height);

        if($this->extension == 'jpeg' or $this->extension == "jpg")
        {
            $source = imagecreatefromjpeg($this->destination);
            imagecopyresampled($this->thumb,$source,0,0,$x,$y,$width,$height,$width,$height);
            imagejpeg($this->thumb,$this->destination,100);
        }
        if($this->extension == 'png')
        {
            $source = imagecreatefrompng($this->destination);
            imagecopyresampled($this->thumb,$source,0,0,$x,$y,$width,$height,$width,$height);
            imagepng($this->thumb,$this->destination,9);
        }
        if($this->extension == 'gif')
        {
            $source = imagecreatefromgif($this->destination);
            imagecopyresampled($this->thumb,$source,0,0,$x,$y,$width,$height,$width,$height);
            imagegif($this->thumb,$this->destination);
        }
    }

    public function coloriz($color,$alpha)
    {
        imagefilter($this->thumb,IMG_FILTER_COLORIZE,$color[0],$color[1],$color[2],$alpha);
        if($this->extension == 'jpeg' or $this->extension == "jpg")
        {
            imagejpeg($this->thumb,$this->destination,100);
        }
        if($this->extension == 'png')
        {
            imagepng($this->thumb,$this->destination,9);
        }
        if($this->extension == 'gif')
        {
            imagegif($this->thumb,$this->destination);
        }
    }

    public function __destruct()
    {
        imagedestroy($this->thumb);
    }
}