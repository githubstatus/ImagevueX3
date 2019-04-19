<?php
if(!isset($_SESSION)) session_start();

ini_set( 'error_reporting', E_ALL ^ E_DEPRECATED );
error_reporting( E_ALL ^ E_DEPRECATED );
ini_set('log_errors',TRUE);
ini_set('html_errors',FALSE);
ini_set('error_log','filemanager_error_log.txt');
ini_set('display_errors',FALSE);

define("PANEL_DIR_NAME", ".");

include 'config.php';
require_once 'filemanager_assets/JSON.php';
require_once 'X3.php';

class filemanager_core extends Services_JSON
{
	var $db;
	public $admin_firstname = "";
	public $admin_lastname = "";
	public $admin_email = "";
	public $admin_id = "";
	public $admin_username = "";
  public $pageCount = 1;
  public $start; // for loop start
  public $end; // for loop end
  public $role;
  public $db_use;
  public $token = "";

  private $secret1 = "*-p";
  private $secret2 = "a#";

  // X3
  static $server_protocol = 'http://';

	function __construct(){
		$this::$server_protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
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

    // is guest?
    public function is_guest(){
        return X3Config::$config["back"]["panel"]["username"] === 'guest' && X3Config::$config["back"]["panel"]["password"] === 'guest' && !isset($_SESSION['filemanager_super']);
    }

    // enforce url setting
	public function enforce_url(){

		if(!isset($_GET["noredirect"])){

			// get config and request
	  	$request = $this::$server_protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	  	// proceed only if not empty and not already enforce URL
	  	if(!empty(X3Config::$config["back"]["enforce_url"]) && stripos($request, X3Config::$config["back"]["enforce_url"]) !== 0){

	  		// trim it properly
	  		$enforce_url = trim(X3Config::$config["back"]["enforce_url"], ' /:');

	  		// continue if not empty
	  		if(!empty($enforce_url)){

	  			// SSL/https
	  			if((strtolower($enforce_url) === 'ssl' || strtolower($enforce_url) === 'https') && $this::$server_protocol !== 'https://'){
	  				$redirect_path = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	  			// www
	  			} else if(strtolower($enforce_url) === 'www' && stripos($_SERVER['HTTP_HOST'], 'www.') !== 0){
	  				$redirect_path = $this::$server_protocol . 'www.' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	  			// match
	  			} else if(stripos($request, $enforce_url) !== 0){
		  			$root_path = str_replace("\\", '', dirname(dirname($_SERVER['PHP_SELF'])));
		  			$redirect_path = $enforce_url . ($root_path === '/' ? $_SERVER['REQUEST_URI'] : substr($_SERVER['REQUEST_URI'], strlen($root_path)));
		  		}

		  		// process redirect
		  		if(isset($redirect_path)){
		  			if(!preg_match('/\/$/', $redirect_path) && !preg_match('/[\.\?\&][^\/]+$/', $redirect_path)) $redirect_path .= '/';
		  			header('HTTP/1.1 301 Moved Permanently');
	      		header('Location:'.$redirect_path);
	      		return true;
		  		}
	  		}
	  	}
  	}
	}

		public function touchme_error(){
			return '{ "error": "Oops, can\'t write to /content" }';
		}

		public function touchme(){
			$file = '../content';
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
                    if( USERNAME == $username and PASSWORD == $password ) {
                        $this->role = "admin";
                        $_SESSION['filemanager_admin'] = md5( $username );
                        if($this->is_guest() && isset($_POST["super"]) && isset(X3Config::$config["back"]["panel"]["super"]) && $_POST["super"] === X3Config::$config["back"]["panel"]["super"]) $_SESSION['filemanager_super'] = true;
                        return true;
                    }
                    global $users;
                    if( isset( $users[$username] ) ) {
                        if( $users[$username]["password"] == $password ) {
                            $this->role = "user";
                            $_SESSION['filemanager_user'] = md5( $username );
                            return true;
                        }
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
            if( $this->role == "user" ) {
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
            if( $this->role == "admin" ) {
                $auth = USERNAME.$this->secret1.PASSWORD.$this->secret2.$this->role;
                if( $auth == $this->decode_this_session( $_SESSION["lift_filemanager_auth"] ) ) {
                    return true;
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

    private function encode_me($txt)
    {
        $txt = strip_tags($txt);
        $txt = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $txt) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
        $txt = urlencode($txt);
        return $txt;
    }

    private function decode_me($txt)
    {
        $txt = urldecode($txt);
        $txt = stripslashes($txt);
        return $txt;
    }

	public function isLogin()
	{
        if( $this->db_use ) {
            if(isset($_SESSION['filemanager_admin']))
            {
                $ck_id = $_SESSION['filemanager_admin'];
                $query = "SELECT is_login,ck_id FROM filemanager_db WHERE is_login='1' AND ck_id='$ck_id' LIMIT 1";
                if($select = mysqli_query($GLOBALS["___mysqli_ston"], $query))
                {
                    $result = mysqli_fetch_array($select,  MYSQLI_ASSOC);
                    if($result["ck_id"] == $ck_id and $result["is_login"] == "1")
                    {
                        $this->role = "admin";
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
            else if(isset($_SESSION['filemanager_user']))
            {
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
            else
            {
                return false;
            }
        }
        else {
            return $this->check_none_db_auth_token();
        }
	}

    public function login($username,$password)
    {
        $password = md5($password);
        $return["status"] = false;
        $return["msg"] = "";
        if( $this->db_use ) {
            $username = $this->encode_me($username);
            $select_query = "SELECT id,is_login,email,username,password,ck_id,luck_count,luck_time FROM filemanager_db WHERE username='$username' OR email='$username'";
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
                        $login = true;
                        $date = date("YmdHis");
                        $ck_id = md5($result["email"].rand());
                        $_SESSION["filemanager_admin"] = $ck_id;
                        $id = $result["id"];
                        $username = $this->encode_me($username);
                        $update_query = "UPDATE filemanager_db SET is_login='1', ck_id='$ck_id', luck_count=0 WHERE username='$username' OR email='$username' AND id='$id'";
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
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_db SET luck_count='$count', luck_time='$date' WHERE id='$id'");
            return false;
        }
        else
        {
            return true;
        }
    }

    public function dir_file_clear_str( $txt )
    {
        $newName = str_replace("...", "../", $txt);
        $newName = str_replace("///", "/", $newName);
        $newName = str_replace("//", "/", $newName);
        $newName = str_replace( "\\\\\\", "\\", $newName );
        $newName = str_replace( "\\\\", "\\", $newName );
        return $newName;
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

    public function forgotPassword($email) // must be add
    {
        $result["status"] = false;
        $result["msg"] = "Forgot_Pass_Error_1";
        $check = $this->encode_me($email);
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, firstname, lastname, email, password FROM filemanager_db WHERE email='$check'");
        $num = mysqli_num_rows($select);
        if($num > 0)
        {
            while($row = mysqli_fetch_array($select))
            {
                if($row["email"] == $check)
                {
                    $newPass = substr($row["password"], 1, 6);
                    $newPass = $newPass.rand();
                    $newPass_save = md5($newPass);
                    $id = $row["id"];
                    $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_db SET password='$newPass_save' WHERE id='$id'");
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
                        $link = str_replace("ajax_show_users.php", "", $link);

                        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https' : 'http';
                        preg_match("/^(".$protocol.":\/\/www\.)?([^\/]+)/i",
                            $_SERVER['SERVER_NAME'], $matches);
                        $host = $matches[2];
                        preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

                        //$host = "noreply@".$host;
                        $link = $protocol."://".$logink;

                        $message = "Hi ".$fullname.",<br><br>Your new password: ".$newPass."<br><br><a href=\"".$link."\">click here</a> to log in.";

                        if($this->x3_mailer($to, $subject, $message)){
                        	$result["status"] = true;
                           $result["msg"] = "done";
                        } else {
                        	$result["status"] = 'email';
                           $result["msg"] = "Forgot_Pass_Error_3";
                        }
                    }
                    else
                    {
                        $result["status"] = 'email';
                        $result["msg"] = "Forgot_Pass_Error_2";
                    }
                }
            }
        }
        return $result;
    }

    public function logout()
    {
        if( $this->db_use ) {
            $check_id = $_SESSION["filemanager_admin"];
            $select_query = "SELECT is_login, ck_id FROM filemanager_db WHERE is_login='1' AND ck_id='$check_id'";
            if($select = mysqli_query($GLOBALS["___mysqli_ston"], $select_query))
            {
                while ($result = mysqli_fetch_array($select))
                {
                    if($result["is_login"] == "1" and $result["ck_id"] == $check_id)
                    {
                        $date = date("YmdHis");
                        $update_query = "UPDATE filemanager_db SET is_login='0', ck_id='' WHERE ck_id='$check_id'";
                        if(mysqli_query($GLOBALS["___mysqli_ston"], $update_query))
                        {
                            $_SESSION["filemanager_admin"] = "logout";
                            unset($_SESSION["filemanager_admin"]);
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
    }

    public function adminInfo()
    {
        if(isset($_SESSION["filemanager_admin"]))
        {
            if( $this->db_use ) {
                $ck_id = $_SESSION["filemanager_admin"];
                $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM filemanager_db WHERE is_login='1' AND ck_id='$ck_id'");
                while ($row = mysqli_fetch_array($query))
                {
                    if($row["ck_id"] == $ck_id)
                    {
                        $this->admin_username = $this->decode_me($row["username"]);
                        $this->admin_firstname = $this->decode_me($row["firstname"]);
                        $this->admin_lastname = $this->decode_me($row["lastname"]);
                        $this->admin_email = $this->decode_me($row["email"]);
                        $this->admin_id = $row["id"];
                    }
                }
            }
            else {
                if( $this->check_none_db_auth_token() ) {
                    $this->admin_username = USERNAME;
                    $this->admin_firstname = FIRSTNAME;
                    $this->admin_lastname = LASTNAME;
                    $this->admin_email = EMAIL;
                    $this->admin_id = ID;
                }
            }
        }
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

	public function editProfile($id, $username, $firstname, $lastname, $email)
	{
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM filemanager_users WHERE (username='$username' OR email='$email') AND id<>'$id'");
        $num = mysqli_num_rows($select);
        if($num > 0)
        {
            echo "null";
            exit;
        }

        if($this->isLogin())
        {
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_db SET username='$username', firstname='$firstname', lastname='$lastname', email='$email' WHERE id='$id'");
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

	public function editPassword($id, $new)
	{
        if($this->isLogin())
        {
            $new = md5($new);
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_db SET password='$new' WHERE id='$id'");
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
            echo "false";
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

    public function get_allow_uploads()
    {
        /*$content = array();
        $select = mysql_query("SELECT * FROM filemanager_options WHERE option_name='allow_uploads'");
        while($row = mysql_fetch_array($select))
        {
            if($row["option_name"] == "allow_uploads")
            {
                $content = $this->decode($row["option_content"]);
            }
        }

        return $content;*/
        global $ALLOW_UPLOADER;
        return $ALLOW_UPLOADER;
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

    public function add_new_user($username, $email, $firstname, $lastname, $password, $send_pass, $user_dir, $limitation, $upload_limitation, $deny_files, $user_perm, $user_ext, $user_up)
    {
        $username = $this->encode_me($username);
        $email = $this->encode_me($email);
        $firstname = $this->encode_me($firstname);
        $lastname = $this->encode_me($lastname);
        $email_pass = $password;
        $password = md5($password);
        $user_dir = str_replace("../", ROOT_DIR_NAME."/", $user_dir);
        $user_dir = $this->encode_me($user_dir);
        if($limitation == 0) $limitation = 1000000000;
        $date = date("YmdHis");
        if($deny_files == "")
        {
            $deny_files = array();
        }
        else
        {
            $deny_files = explode(", ", $deny_files);
        }
        $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO filemanager_users (firstname, lastname, username, email, password, is_login, is_block, dir_path, date_added) VALUES ('$firstname', '$lastname', '$username', '$email', '$password', 0, 0, '$user_dir', '$date')");
        if($insert)
        {
            $user_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
            require_once PANEL_DIR_NAME.'/option_class.php';
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
                                    if($send_pass == "send")
                                    {
                                        $to = $this->decode_me($email);
                                        $username = $this->decode_me($username);
                                        $subject = "Account Info";
                                        $fullname = $this->decode_me($firstname." ".$lastname);
                                        $filename = basename($_SERVER["PHP_SELF"]);
                                        $this_file_path = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                                        $link = str_replace("filemanager_admin/".$filename, "filemanager_user/", $this_file_path);
                                        $link = str_replace("ajax_show_users.php", "", $link);

                                        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https' : 'http';
                                        preg_match("/^(".$protocol.":\/\/www\.)?([^\/]+)/i",
                                            $_SERVER['SERVER_NAME'], $matches);
                                        $host = $matches[2];
                                        preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

                                        $host = "noreply@".$host;
                                        $link = $protocol."://".$link;

                                        /*$headers = "From: " . $host . "\r\n";
                                        $headers .= "MIME-Version: 1.0\r\n";
                                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";*/

                                        $message = "Hi ".$fullname.", <br><br>X3 Panel<br><strong>username:</strong> ".$username."<br /><strong>password</strong>: ".$email_pass." <br/><br/>You can <a href=\"".$link."\">click here</a> to log in.";

                                        if(!$this->x3_mailer($to, $subject, $message)) return null;
                                        return true;
                                    }
                                    else
                                    {
                                        return true;
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

    public function delete_user($user_id)
    {
        $delete = mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM filemanager_users WHERE id='$user_id'");
        if($delete)
        {
            require_once PANEL_DIR_NAME.'/option_class.php';
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
            $this->delete_tickets_of_user($user_id);
            return true;
        }
        else
        {
            return false;
        }
    }

    private function delete_tickets_of_user($userId)
    {
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM filemanager_tickets WHERE userId='$userId'");
        $num = mysqli_num_rows($select);
        if($num > 0)
        {
            while($row = mysqli_fetch_array($select))
            {
                $id = $row["id"];
                mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM filemanager_tickets WHERE id='$id' OR parentId='$id'");
            }
        }
    }

    public function edit_user($username, $email, $firstname, $lastname, $password, $send_pass, $user_dir, $limitation, $upload_limitation, $deny_files, $user_perm, $user_ext, $user_up, $user_id)
    {
        $username = $this->encode_me($username);
        $email = $this->encode_me($email);
        $firstname = $this->encode_me($firstname);
        $lastname = $this->encode_me($lastname);
        $email_pass = "Your recent password";
        if($password != "")
        {
            $email_pass = $password;
            $password = md5($password);
        }
        $user_dir = str_replace("../", ROOT_DIR_NAME."/", $user_dir);
        $user_dir = $this->encode_me($user_dir);
        if($limitation == 0) $limitation = 1000000000;
        if($deny_files == "")
        {
            $deny_files = array();
        }
        else
        {
            $deny_files = explode(", ", $deny_files);
        }
        if($password != "")
        {
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$password', dir_path='$user_dir' WHERE id='$user_id'");
        }
        else
        {
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', dir_path='$user_dir' WHERE id='$user_id'");
        }
        if($update)
        {
            require_once PANEL_DIR_NAME.'/option_class.php';
            $option = new option_class();
            $name = "allow_extensions_".$user_id;
            if($option->update_option($name, $user_ext))
            {
                $name = "allow_uploads_".$user_id;
                if($option->update_option($name, $user_up))
                {
                    $name = "permission_for_".$user_id;
                    if($option->update_option($name, $user_perm))
                    {
                        $name = "deny_folders_".$user_id;
                        if($option->update_option($name, $deny_files))
                        {
                            $name = "user_limit_".$user_id;
                            if($option->update_option($name, $limitation))
                            {
                                $name = "user_upload_limit_".$user_id;
                                if($option->update_option($name, $upload_limitation))
                                {
                                    if($send_pass == "send")
                                    {
                                        $to = $this->decode_me($email);
                                        $username = $this->decode_me($username);
                                        $subject = "New Account Info";
                                        $fullname = $this->decode_me($firstname." ".$lastname);

                                        preg_match("/^(http:\/\/)?([^\/]+)/i",
                                            $_SERVER['SERVER_NAME'], $matches);
                                        $host = $matches[2];
                                        preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);

                                        $host = "noreply@".$host;

                                        $message = "Hi ".$fullname."; <br> This is your new username: ".$username." and password: ".$email_pass.". <br>Please do not reply.";

                                        if(!$this->x3_mailer($to, $subject, $message)) return null;
                                        return true;
                                    }
                                    else
                                    {
                                        return true;
                                    }
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
        else
        {
            return false;
        }
    }

    public function get_users()
    {
        //$users = "";
        $users = array();
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM filemanager_users ORDER BY date_added DESC");
        if($select)
        {
            require_once PANEL_DIR_NAME.'/option_class.php';
            $option = new option_class();
            while($row = mysqli_fetch_array($select))
            {
                $users["id"][] = $row["id"];
                $users["firstname"][] = $this->decode_me($row["firstname"]);
                $users["lastname"][] = $this->decode_me($row["lastname"]);
                $users["username"][] = $this->decode_me($row["username"]);
                $users["email"][] = $this->decode_me($row["email"]);
                $users["is_block"][] = $row["is_block"];
                $users["dir_path"][] = $this->decode_me($row["dir_path"]);
                $users["date_added"][] = $row["date_added"];
                $users["permissions"][] = $this->switch_user_permission($option->get_option("permission_for_".$row["id"]));
                $users["filemanager_ext"][] = $option->get_option("allow_extensions_".$row["id"]);
                $users["uploader_ext"][] = $option->get_option("allow_uploads_".$row["id"]);
                $users["deny_folders"][] = $option->get_option("deny_folders_".$row["id"]);
                $limitation = $option->get_option("user_limit_".$row["id"]);
                $users["user_limit"][] = $limitation;
                $limitation = ($limitation * 1024) * 1024;
                $users["limitation"][] = $this->set_limitation($this->decode_me($row["dir_path"]), $limitation);
                $users["upload_limitation"][] = $option->get_option("user_upload_limit_".$row["id"]);
            }
        }
        return $users;
    }
    private function set_limitation($directory, $limitation)
    {
        if(is_dir($directory))
        {
            $size = 0;
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file)
            {
                $size += $file->getSize();
            }
            $limit = ($size / $limitation) * 100;
        }
        else
        {
            $limit = 0;
        }
        return $limit;
    }

    private function switch_user_permission($array)
    {
        foreach($array as $key => $value)
        {
            switch($value)
            {
                case "edit_profile":
                    $array[$key] = "Edit Profile";
                break;
                case "edit_settings":
                    $array[$key] = "Edit Settings";
                    break;
                case "create_folder":
                    $array[$key] = "Create Folder";
                break;
                case "rename_folder":
                    $array[$key] = "Rename Files And Folders";
                break;
                case "copy_folders":
                    $array[$key] = "Copy Files And Folders";
                break;
                case "move_folders":
                    $array[$key] = "Move Files And Folders";
                break;
                case "remove_folders":
                    $array[$key] = "Remove Folders";
                break;
                case "zip_folders":
                    $array[$key] = "Zip Files And Folders";
                break;
                case "upload_folders":
                    $array[$key] = "Upload Files";
                break;
                case "backup_folders":
                    $array[$key] = "Create Backup";
                break;
                case "edit_files":
                    $array[$key] = "Edit Text Files";
                break;
                case "edit_img":
                    $array[$key] = "Edit Images";
                break;
                case "unzip_files":
                    $array[$key] = "Extract Zip Files";
                break;
            }
        }
        return $array;
    }

    public function get_user($id)
    {
        $users = array();//"";
        $select = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM filemanager_users WHERE id='$id'");
        if($select)
        {
            require_once PANEL_DIR_NAME.'/option_class.php';
            $option = new option_class();
            while($row = mysqli_fetch_array($select))
            {
                $users["id"] = $row["id"];
                $users["firstname"] = $this->decode_me($row["firstname"]);
                $users["lastname"] = $this->decode_me($row["lastname"]);
                $users["username"] = $this->decode_me($row["username"]);
                $users["email"] = $this->decode_me($row["email"]);
                $users["dir_path"] = $this->decode_me($row["dir_path"]);
                $users["dir_path"] = str_replace(ROOT_DIR_NAME."/", "../", $users["dir_path"]);
                $users["permissions"] = $option->get_option("permission_for_".$row["id"]);
                $users["filemanager_ext"] = $option->get_option("allow_extensions_".$row["id"]);
                $users["uploader_ext"] = $option->get_option("allow_uploads_".$row["id"]);
                $users["deny_folders"] = $option->get_option("deny_folders_".$row["id"]);
                $users["limitation"] = $option->get_option("user_limit_".$row["id"]);
                if($users["limitation"] == 1000000000) $users["limitation"] = 0;
                $users["upload_limitation"] = $option->get_option("user_upload_limit_".$row["id"]);
            }
        }
        return $users;
    }

    public function block_user($user_id, $method)
    {
        if($method == 0)
        {
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_users SET is_block=1 WHERE id='$user_id'");
            if($update)
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
            $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE filemanager_users SET is_block=0 WHERE id='$user_id'");
            if($update)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
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

    public function get_base_root()
    {
        /*$select = mysql_query("SELECT * FROM filemanager_options WHERE option_name='base_root_folder'");
        $row = mysql_fetch_array($select, MYSQL_ASSOC);
        return base64_decode($row["option_content"]);*/
        return realpath(ROOT_DIR_NAME);
    }

    public function check_base_root($newName)
    {
        if($newName != ROOT_DIR_NAME)
        {
            $check_address = explode("/", $newName);
            $count = count($check_address);
            for($i = 0; $i < $count; $i++)
            {
                if($i == $count - 1)
                {
                    unset($check_address[$i]);
                    break;
                }
            }
            $check_address = realpath(implode("/", $check_address));
        }
        else
        {
            $check_address = realpath($newName);
        }

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
    		/*$files = glob($path."/*.json");
    		if(empty($files))
        {
            $fp = fopen($path."/page.json", "w");
            fwrite($fp, "{}");
            fclose($fp);
        }*/

      // optional page date
    	$data = new ArrayObject();
    	if(isset($_POST['title'])) $data['title'] = $_POST['title'];
    	if(isset($_POST['label'])) $data['label'] = $_POST['label'];
    	if(isset($_POST['link']) || isset($_POST['target'])) $data['link'] = new ArrayObject();
    	if(isset($_POST['link'])) $data['link']['url'] = $_POST['link'];
    	if(isset($_POST['target'])) $data['link']['target'] = $_POST['target'];

    	//if(isset($_POST['hidden'])) $data['hidden'] = $_POST['hidden']; // <-- fix hidden
    	//X3::merge_folders($json)
    	if(isset($_POST['hidden']) && $_POST['hidden']) {
    		$ob = array();
    		$ob[X3::get_content_path($path)]['hidden'] = true;
    		X3::merge_folders($ob);
    	}

    	// create json object and write contents to page.json
    	$json = phpversion() < 5.4 ? json_encode($data) : json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    	file_put_contents($path . '/page.json', $json);
    }
}

class filemanager_backups extends filemanager_core
{
	private $backup_dir = "../filemanager_backups";
	public $backup_dir_files = NULL;
	function __construct()
	{
		$ignored = array('.', '..', 'backups.php', '.htaccess');
	    foreach (scandir($this->backup_dir) as $file) 
	    {
	        if (in_array($file, $ignored)) continue;
	        $this->backup_dir_files[$file] = filemtime($this->backup_dir . '/' . $file);
	    }
	    @arsort($this->backup_dir_files);
	    @$this->backup_dir_files = array_keys($this->backup_dir_files);
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
}

class filemanager_edit_files extends filemanager_core
{
	public function remove_this_backup_file($name)
	{
		$filename = "../filemanager_backups/".$name;
		if (is_file($filename))
		{
			if(@unlink($filename))
			{
				echo "T";
			}
			else
			{
				echo "F1";
			}
		}
		else
		{
			echo "F2";
		}
	}
}

class filemanager_show_from_root extends Services_JSON
{
	public  $root_files_folders;
	private $root_dir = "";
	private $ignored = array(PANEL_DIR_NAME, '.', '..', 'filemanager_user_core.php','config.php', 'filemanager_config.php', 'filemanager_core.php', 'filemanager_language.php', 'filemanager_language_user.php', 'filemanager_js', 'filemanager_install', 'filemanager_css', 'filemanager_backups', 'filemanager_admin', 'filemanager_img', 'filemanager_assets', 'filemanager_user', 'filemanager_temp', 'filemanager_fonts', 'filemanager_img/pattern', 'filemanager_img/fancy', 'filemanager_assets/PHPMailer', 'filemanager_assets/PHPMailer/docs', 'filemanager_assets/PHPMailer/extras', 'filemanager_assets/PHPMailer/language', 'filemanager_assets/PHPMailer/test', 'filemanager_assets/securimage', 'filemanager_assets/securimage/backgrounds', 'filemanager_assets/securimage/images', 'filemanager_assets/securimage/words', 'services', 'sitemap', 'json', 'feed', 'custom');
	private $suppurt_ext;
	private $sort;
    private $search;
    public  $loading_this_file;
	function __construct($show_root, $path = '', $sort_with = 'date', $search = '')
	{
		$this->sort = $sort_with;
		$this->suppurt_ext = $this->get_support_ext();
        $this->search = $search;
        $this->set_root_dir_folder();
        $this->check_json_file($path);
		if($show_root)
			$this->get_files_folders();
		else
			$this->show_dir($path);
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

    private function check_search_directory($dir)
    {
        $newName = $dir;
        if($newName != ROOT_DIR_NAME)
        {
            $check_address = explode("/", $newName);
            $count = count($check_address);
            for($i = 0; $i < $count; $i++)
            {
                if($i == $count - 1)
                {
                    unset($check_address[$i]);
                    break;
                }
            }
            $check_address = realpath(implode("/", $check_address));
        }
        else
        {
            $check_address = realpath($newName);
        }
        $check_root = realpath( ROOT_DIR_NAME );
        if(strpos($check_address, $check_root) === FALSE)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    private function find_all_files($dir, $extensions, $search)
    {
        $root = scandir($dir);
        foreach($root as $value)
        {
            if($value === '.' or $value === '..') continue;
            if(is_file($dir."/".$value))
            {
                $_ext = explode(".", $value);
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
                    $filename = $file = $dir."/".$value;//str_replace(ROOT_DIR_NAME."/", "", $file);
                    $this->root_files_folders[$filename] = filemtime($file);
                }
            }
        }
    }

    private function findFiles($directory, $extensions = array())
    {
        /* Search in Root Dir */
        $directory = ROOT_DIR_NAME;

        if($this->check_search_directory($directory))
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

	public function get_files_folders()
	{
        if($this->search != '')
        {
            $this->findFiles($this->root_dir, $this->suppurt_ext);
        }
        else
        {
            foreach (scandir($this->root_dir) as $file)
            {
                if (in_array($file, $this->ignored)) continue;
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
            $size += $file->getSize();
        }
        return $size;
    }

    public function show_dir($path)
	{
        if($this->search != '')
        {
            $this->findFiles($path, $this->suppurt_ext);
        }
        else
        {
            $mypath = is_dir($path) ? $path : array();
            foreach (scandir($mypath) as $file)
            {
                if (in_array($file, $this->ignored)) continue;
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

    private function get_support_ext()
    {
        /*$content = array();
        $select = mysql_query("SELECT * FROM filemanager_options WHERE option_name='allow_extensions'");
        while($row = mysql_fetch_array($select))
        {
            if($row["option_name"] == "allow_extensions")
            {
                $content = $this->decode($row["option_content"]);
            }
        }
        return $content;*/
        global $ALLOW_EXTENSIONS;
        return $ALLOW_EXTENSIONS;
    }
}

class editImage
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


?>