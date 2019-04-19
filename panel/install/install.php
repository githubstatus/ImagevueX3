<?php
require_once '../config.php';
require_once '../filemanager_assets/JSON.php';
class INSTALL extends Services_JSON
{
	var $db;
    public $status = false;
	function __construct()
	{
		$this->db = ($GLOBALS["___mysqli_ston"] = mysqli_connect(DB_HOST, DB_USER, DB_PASS));
		((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . constant('DB_NAME')));
	}

	public function _install($firstname,$lastname,$username,$email,$password)
	{
		$table_query = "CREATE TABLE IF NOT EXISTS filemanager_db(
				  id INT NOT NULL AUTO_INCREMENT, 
				  PRIMARY KEY(id),
				  firstname TEXT,
				  lastname TEXT,
				  username TEXT,
				  email TEXT,
				  password TEXT,
				  is_login TINYINT,
				  date_added DATETIME
				  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		if(mysqli_query($GLOBALS["___mysqli_ston"], $table_query))
		{
			$date_added = date("YmdHis");
			$is_login = 0;
			$is_admin = 1;
			$is_block = 0;
            $email_poasword = $password;
			$password = md5($password);
			$insert_query = "INSERT INTO filemanager_db (firstname,lastname,username,email,password,is_login,date_added) VALUES ('$firstname','$lastname','$username','$email','$password','$is_login','$date_added')";
			if(mysqli_query($GLOBALS["___mysqli_ston"], $insert_query))
			{
                $table_query = "CREATE TABLE IF NOT EXISTS filemanager_options(
				  id INT NOT NULL AUTO_INCREMENT,
				  PRIMARY KEY(id),
				  option_name VARCHAR(30),
				  option_content TEXT
				  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;"; // UPDATE V1.0.1
                if(mysqli_query($GLOBALS["___mysqli_ston"], $table_query))
                {
                    $table_query = "CREATE TABLE IF NOT EXISTS filemanager_users(
                              id INT NOT NULL AUTO_INCREMENT,
                              PRIMARY KEY(id),
                              firstname TEXT,
                              lastname TEXT,
                              username TEXT,
                              email TEXT,
                              password TEXT,
                              is_login TINYINT,
                              is_block TINYINT,
                              dir_path TEXT,
                              date_added DATETIME
				          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";// UPDATE V1.0.1
                    if(mysqli_query($GLOBALS["___mysqli_ston"], $table_query))
                    {
                        $name = "allow_extensions";
                        $content = array('rar','zip','txt','pdf','jpg','jpeg','png','gif','bmp','psd','flv','mp4','gpx','webp');
                        $content = $this->_encode($content);
                        $insert_options = "INSERT INTO filemanager_options (option_name, option_content) VALUES ('$name' , '$content')";
                        if(mysqli_query($GLOBALS["___mysqli_ston"], $insert_options))
                        {

                            $name = "allow_uploads";
                            $content =  array("gif", "jpeg", "jpg", "png", "txt", "zip", "rar", "psd", "flv", "mp4",'gpx','webp');
                            $content = $this->_encode($content);
                            $insert_options = "INSERT INTO filemanager_options (option_name, option_content) VALUES ('$name' , '$content')";
                            if(mysqli_query($GLOBALS["___mysqli_ston"], $insert_options))
                            {
                                $email = urldecode($email);
                                $username = urldecode($username);
                                $firstname = urldecode($firstname);
                                $lastname = urldecode($lastname);

                                // New X3 SMTP
				                        $host = "noreply@".$_SERVER['SERVER_NAME'];
																$link = str_replace("install/install.php", "", "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);

				                        // mail details
				                        $subject = "X3 Panel installed.";
                                $message = "<strong>username:</strong> ".$username."<br><strong>password:</strong> ".$email_poasword."<br><br>".$link;

                                // initiate X3 PHPMailer router
												        require '../../app/x3.mail.inc.php';
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
												        $phpMailer->addAddress($email);
												        $phpMailer->Subject = $subject;
												        $phpMailer->IsHTML(true);
												        $phpMailer->Body = $message;
				                        if($phpMailer->send()){
				                            echo '<div class="alert alert-success"><center>';
                                    echo "X3 panel has been installed and an email has been sent.<br><a href='".$link."'>Login</a>";
                                    echo '</center></div>';
				                        } else {
				                            echo '<div class="alert alert-success"><center>';
                                    echo "X3 panel has been installed.<br><a href='".$link."'>Login</a>";
                                    echo '</center></div>';
				                        }

                                $this->status = true;
                            }
                            else
                            {
                                echo '<div class="alert alert-error"><center>';
                                echo "ERROR: ".((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
                                echo '</center></div>';
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-error"><center>';
                            echo "ERROR: ".((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
                            echo '</center></div>';
                        }
                    }
                    else
                    {
                        echo '<div class="alert alert-error"><center>';
                        echo "ERROR: ".((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
                        echo '</center></div>';
                    }
                }
                else
                {
                    echo '<div class="alert alert-error"><center>';
                    echo "ERROR: ".((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
                    echo '</center></div>';
                }
			}
			else
			{
				echo '<div class="alert alert-error"><center>';
				echo "ERROR: ".((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
				echo '</center></div>';
			}
		}
		else
		{
			echo '<div class="alert alert-error"><center>';
			echo "ERROR: ".((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
			echo '</center></div>';
		}
	}
}
?>
<html>
<head>
<meta name="robots" content="noindex">
<meta name="googlebot" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="../filemanager_css/x3.panel.css?v=<?php echo X3Config::$config["x3_panel_version"]; ?>" rel="stylesheet" />
</head>
<body>
<?php 
if(isset($_POST["install"]) && $_POST["nickname"] == "googooforgaga" && $_POST["pass"] == "")
{
	$firstname = urlencode($_POST["firstname"]);
	$lastname = urlencode($_POST["lastname"]);
	$username = urlencode($_POST["username"]);
	$email = urlencode($_POST["email"]);
	$password = $_POST["password"];
	$install = new INSTALL();
	$install->_install($firstname, $lastname, $username, $email, $password);
    if($install->status)
    {
        require_once 'update.php';
        $update = new UPDATE_V_2_0_0();
        $update->install_flag = true;
        $update->update();
    }
} else {
	header("Location: ./");
	exit();
}
?>
</body>