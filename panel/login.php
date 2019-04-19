<?php

if (!isset($core))
{
    require_once 'filemanager_core.php';
    $core = new filemanager_core();
    if($core->enforce_url()) return;
}
if ($core->isLogin()){
    header("Location: .");
} else {
    $result = '';
    if (isset($_POST["login"]))
    {
        if( isset( $_SESSION["filemanager_language"] ) ) {
            unset( $_SESSION["filemanager_language"] );
        }
        if( isset( $_POST["filemanager_lang"] ) and $_POST["filemanager_lang"] != "en" ) {
            $lng = str_replace( "/", "", $_POST["filemanager_lang"] );
            $lng = str_replace( "\\", "", $_POST["filemanager_lang"] );
            $_SESSION["filemanager_language"] = $lng;
        }
        $login = $core->login($_POST["username"], $_POST["password"]);
        if ($login["status"] == true && $_POST["nickname"] == "googooforgaga" && $_POST["pass"] == "")
        {
            header("Location: .");
        }
        else
        {
            require_once 'filemanager_user_core.php';
            $core = new filemanager_user_core();
            $login = $core->login($_POST["username"], $_POST["password"]);
            if ($login["status"] == true && $_POST["nickname"] == "googooforgaga" && $_POST["pass"] == "")
            {
                header("Location: .");
            }
            else
            {
                if(!isset($language))
                {
                    require_once 'filemanager_language.php';
                }
                if($login["msg"] == "check")
                {
                    $login["msg"] = language_filter("Login_Error", true);
                }
                else
                {
                    $login["msg"] = language_filter("Login_Block", true);
                }
                $result = '<div class="alert alert-danger"><center>'.$login["msg"].'</center></div>';
            }
        }
    }

    if(isset( $_POST["fotgotpass"] ) and $core->db_use )
    {
        $forgot_pass = $core->forgotPassword($_POST["email_forgot"]);
        if(!isset($language))
        {
            require_once 'filemanager_language.php';
        }
        if($forgot_pass["status"] === true and $forgot_pass["msg"] == "done" )
        {
            $forgot_pass["msg"] = language_filter("Forgot_Pass_Success", true);
            $result = '<div class="alert alert-success"><center>'.$forgot_pass["msg"].'</center></div>';
        }
        else
        {
            if( $forgot_pass["status"] == "email" ) {
                $forgot_pass["msg"] = language_filter($forgot_pass["msg"], true);
                $result = '<div class="alert alert-danger"><center>'.$forgot_pass["msg"].'</center></div>';
            }
            else {
                require_once 'filemanager_user_core.php';
                $core = new filemanager_user_core();
                $forgot_pass = $core->forgotPassword($_POST["email_forgot"]);
                if($forgot_pass["status"])
                {
                    $forgot_pass["msg"] = language_filter("Forgot_Pass_Success", true);
                    $result = '<div class="alert alert-success"><center>'.$forgot_pass["msg"].'</center></div>';
                }
                else
                {
                    $forgot_pass["msg"] = language_filter($forgot_pass["msg"], true);
                    $result = '<div class="alert alert-danger"><center>'.$forgot_pass["msg"].'</center></div>';
                }
            }

        }
    }

    if(!isset($language))
    {
        require_once 'filemanager_language.php';
    }

    /* Select available */
    function select_languages() {
        $dir = __DIR__."/filemanager_assets/lng";
        if( is_dir( $dir ) ) {
        		$files = glob($dir."/*.php", GLOB_NOSORT);
            if( !empty( $files ) ) {
                echo '<select class="form-control" name="filemanager_lang">';
                $session_lang = empty($_SESSION["filemanager_language"]) ? X3Config::$config["back"]["panel"]["language"] : $_SESSION["filemanager_language"];
                foreach( $files as $file ) {
                    $lang  = basename( $file, ".php" );
                    $selected = ($session_lang == $lang) ? 'selected' : '';
                    echo '<option value="'.$lang.'" '.$selected.'>'.$lang.'</option>';
                }
                echo '</select>';
            }
        }
    }

    // Check default login
    if(X3Config::$config["back"]["panel"]["username"] === "admin" && X3Config::$config["back"]["panel"]["password"] === "admin" && !X3Config::$config["back"]["panel"]["use_db"]) {
    	$result .= '<div class="alert alert-danger demo-panel" role="alert">
    	<strong>Default Login</strong>
    	<br>admin / admin
    	<div>After login, please proceed immediately to settings &rsaquo; panel and change your login details to protect your panel.</div>
    	</div>';

    // Diagnose DB
    } else if(X3Config::$config["back"]["panel"]["use_db"]) {
    	function addItem($status, $title, $description, $add_link = true){
				$str = "<div class=\"x3-diagnostics-item x3-diagnostics-".$status."\">";
				if(!empty($title)) $str .= "<strong>".$title."</strong>";
				if($add_link) $description .= '<br><br>Try the X3 <a class=dcb href="./db_check.php" target=_blank>Database Connection Checker</a>, and check your <a href=../?diagnostics target=_blank>X3 diagnostics</a>. If you need to reset panel login or change database config settings, you will need to login by FTP and edit the following file:<br><code style="display: block; margin: .3em 0 0;padding: .3em .6em;">/config/config.user.json</code>';
				$str .= "<div class=x3-diagnostics-description>".$description."</div></div>";
				return $str;
			}
    	$warning = (string)'';
			if(empty(X3Config::$config["back"]["panel"]["db_host"]) || empty(X3Config::$config["back"]["panel"]["db_user"]) || empty(X3Config::$config["back"]["panel"]["db_pass"]) || empty(X3Config::$config["back"]["panel"]["db_name"])){
				$warning .= addItem("warning", "Missing database details", "You have enabled the database-version of the panel, but one or more database connection details are empty.");
			} else if(function_exists('mysqli_connect')){

				# DB vars
				$dbname = X3Config::$config["back"]["panel"]["db_name"];
				$dbuser = X3Config::$config["back"]["panel"]["db_user"];
				$dbpass = X3Config::$config["back"]["panel"]["db_pass"];
				$dbhost = X3Config::$config["back"]["panel"]["db_host"];

				# Check DB connection
				$connection = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
				if($connection->connect_errno) {
					$msg = (string)$connection->connect_error;

					# Fail DB HOST
					if(strtolower($msg) === 'no such file or directory'){
						$warning .= addItem("warning", "DB HOST connection fail", "Failed to connect to Database HOST <strong>\"" . $dbhost . "\"</strong> (" . $msg . ")");

					# Generic DB connection error
					} else {
						$warning .= addItem("warning", "DB connection fail", "Failed to connect to Database, with given error: <strong>" . $connection->connect_error . "</strong>");
					}
				} else {
					# Check if is installed
					$query = 'SELECT * FROM `filemanager_db` ORDER BY `id` LIMIT 1';
					$db_result = $connection->query($query);
					$install_msg = "Although successfully connected to the database <em>" . $dbname . "</em>, you do not seem to have installed the X3 database panel. Try the <strong><a href=install target=_blank>X3 Panel Install</a></strong> script.";

					if(!$db_result) {
						$warning .= addItem("warning", "X3 Panel DB not installed", $install_msg, false);
					} else {
						$fetch = $db_result->fetch_object();
						if(empty($fetch)) {
							$warning .= addItem("warning", "X3 Panel DB not installed", $install_msg, false);
						}
						$db_result->close();
					}

					# close connection
					$connection->close();
				}
			} else {
				$warning .= addItem("warning", "Missing Mysqli interface", 'Your PHP is missing the necessary mysqli interface to connect to databases.');
			}
		}
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="<?php echo $language["charset"];?>">
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://cdn.jsdelivr.net/bootstrap/3.0.0/css/bootstrap.min.css' rel='stylesheet' />
        <link href="filemanager_css/x3.panel.css?v=<?php echo X3Config::$config["x3_panel_version"]; ?>" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Montserrat:500|Source+Sans+Pro:400,400i,600,600i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #eee;
                direction: <?php echo $language["direction"];?>;
            }
            .container { display: none; }
            .form-signin {
                max-width: 330px;
                padding: 15px;
                margin: 0 auto;
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin .checkbox {
                font-weight: normal;
            }
            .form-signin .form-control {
                position: relative;
                font-size: 16px;
                height: auto;
                padding: 10px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            .form-signin .form-control:focus {
                z-index: 2;
            }
            .form-signin input[type="email"] {
                margin-bottom: -1px;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }
            .form-signin input[type="password"] {
                margin-bottom: 10px;
            }
            .demo-panel > div {
			        font-size: .9em; margin-top: 5px;
			      }
            button.btn-block { display: none; }
            .alert {
            	font-family: 'Source Sans Pro', sans-serif;
            	max-width: 300px;
            	margin: 0 auto;
            	text-align: center;
            }
            .x3-diagnostics-item > strong, .alert > strong {
            	font-size: 1.2em;
            	font-family: 'Montserrat', sans-serif;
            	font-weight: 600;
            }
            .alert strong {
            	font-weight: 600;
            }
            .alert a {
            	color: inherit;
            	text-decoration: underline;
            	padding: 0 .1em;
            }
            .alert a:hover {
            	background: #b94a48;
            	color: white;
            	text-decoration: none;
            }

        </style>

    <title><?php language_filter("Login");?></title>
    </head>
    <body>
    <div class="container">
        <?php
        	echo $result;
        	if(!empty($warning)) echo '<div class="alert alert-danger" role="alert">' . $warning . '</div>';
				?>

				<?php if(empty($warning)) : ?>
        <form class="form-signin" role="form" method="post">
            <h2 class="form-signin-heading"><?php language_filter("Login");?></h2>

            <?php
            // Guest login
            if(X3Config::$config["back"]["panel"]["username"] === 'guest' && X3Config::$config["back"]["panel"]["password"] === 'guest') { echo '<div class="alert alert-success demo-panel" role="alert"><strong>X3 Demo Panel</strong><div>You can login as <strong>guest/guest</strong>, but you will not be able to make any changes.</div></div>'; } ?>

            <input type="text" name="nickname" class="form-control formx" placeholder="nickname">
            <input type="text" name="pass" class="form-control formx" placeholder="pass">
            <input type="text" name="username" class="form-control" placeholder="<?php language_filter("Username");?>" required="required">
            <input type="password" name="password" class="form-control" placeholder="<?php language_filter("Password");?>" required="required">
            <?php if(isset($_GET["super"])): ?><input type="password" name="super" class="form-control" placeholder="super" value="<?php echo $_GET["super"] ?>"><?php endif;?>
            <?php select_languages();?>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login"><?php language_filter("Login Button");?></button>
            <?php if( $core->db_use ): ?><a href="javascript:;" data-toggle="modal" data-target="#forgot"><?php language_filter("Forgot_Pass_Text");?></a><?php endif;?>
        </form>
        <?php endif ?>
    </div> <!-- /container -->


    <!-- Modal -->
    <div class="modal fade" id="forgot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><?php language_filter("Forgot_Pass_Text");?></h4>
                </div>
                <div class="modal-body">
                    <form class="form-signin" role="form" method="post">
                        <input type="email" name="email_forgot" class="form-control" placeholder="<?php language_filter("Forgot_Placeholder");?>" required="required">
                        <br />
                        <button class="btn btn-lg btn-danger btn-block" type="submit" name="fotgotpass"><?php language_filter("Forgot_Btn");?></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php language_filter("Close");?></button>
                </div>
            </div>
        </div>
    </div>
    <script src='https://cdn.jsdelivr.net/jquery/2.2.4/jquery.min.js'></script>
    <script src="https://cdn.jsdelivr.net/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script>
    	var form = $('.form-signin');
    	form.attr('action', 'log'+'in.php');
    	form.find('input[name="nickname"]').val('googooforgaga');
    	form.find('.formx').hide();
    	$('button.btn-block, .container').show();
		  try {
		  	var ls = window.localStorage;
		    ls.setItem('t', 'y');
		    var supports_local_storage = Boolean(ls && 'localStorage' in window && window['localStorage'] !== null && ls.getItem('t') === 'y');
		    ls.removeItem('t');
		  } catch (exception) {
		  	var supports_local_storage = false;
		  }
		  if(supports_local_storage) {
		  	var selected_lang = localStorage.getItem('selected_lang');
		  	if(selected_lang) {
		  		var select = form.find('select');
		  		if(select.children('option[value="' + selected_lang + '"]').length) form.find('select').val(selected_lang);
		  	}
		  }
    </script>
    </body>
    </html>
<?php
}
?>