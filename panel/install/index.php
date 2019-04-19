<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config.php';

?>

<html>
<head>
<meta name="robots" content="noindex">
<meta name="googlebot" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Montserrat:500|Source+Sans+Pro:400,400i,600,600i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<script src='https://cdn.jsdelivr.net/jquery/2.2.4/jquery.min.js'></script>
<link href="../filemanager_css/x3.panel.css?v=<?php echo X3Config::$config["x3_panel_version"]; ?>" rel="stylesheet" />
 <style type="text/css">
     body {
         padding-top: 40px;
         padding-bottom: 40px;
         background-color: #eee;
     }
     .container { display: none; }
     button.btn-block { display: none; }
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
      .db_check {
      	font-family: 'Source Sans Pro', sans-serif;
      	max-width: 600px;
      	margin: 0 auto;
      }
      .x3-diagnostics-item > strong {
      	font-size: 1.2em;
      }
      .db_check a {
      	text-decoration: underline;
      	color: inherit;
      	padding: 0 .1em;
      }
      a.dcb {
      	font-weight: 600;
      }

    </style>
</head>
<body>
<div class="container">

<?php

# disagnostics
$warning = (string)'';

function addItem($status, $title, $description, $add_link = true){
	$str = "<div class=\"x3-diagnostics-item x3-diagnostics-".$status."\">";
	if(!empty($title)) $str .= "<strong>".$title."</strong>";
	if($add_link) $description .= '<br><br>Try the X3 <a class=dcb href="../db_check.php" target=_blank>Database Connection Checker</a>.';
	$str .= "<div class=x3-diagnostics-description>".$description."</div></div>";
	return $str;
}

if(X3Config::$config["back"]["panel"]["use_db"]) {
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
				$warning .= addItem("warning", "DB HOST connnection fail", "Failed to connect to Database HOST <strong>\"" . $dbhost . "\"</strong> (" . $msg . ")");

			# Generic DB connection error
			} else {
				$warning .= addItem("warning", "DB connnection fail", "Failed to connect to Database, with given error: <strong>" . $connection->connect_error . "</strong>");
			}
		} else {
			# Check if is installed
			$query = 'SELECT * FROM `filemanager_db` ORDER BY `id` LIMIT 1';
			$result = $connection->query($query);
			$already = "X3 Panel is already installed in this database. You cannot run the install script multiple times on the same database!";

			if($result) {
				$warning .= addItem("warning", "X3 Panel DB already installed", $already, false);
				$result->close();
			}

			# close connection
			$connection->close();
		}
	} else {
		$warning .= addItem("warning", "Missing Mysqli interface", 'Your PHP is missing the necessary mysqli interface to connect to databases.');
	}
} else {
	$warning .= addItem("warning", "Panel DB version disabled", 'If you want to install the panel database version, you will first have to login to the <a href="../" target=_blank>panel</a> and select <strong>"Use Database"</strong> from settings.', false);
}
if(!empty($warning)) echo '<div class="db_check alert alert-danger" role="alert">' . $warning . '</div>';

if(empty($warning)) : ?>

    <form class="form-signin" name="install_form" method="post" onsubmit="return check_submit();">
        <h2 class="form-signin-heading">Install X3 Panel DB</h2>
        <input type="text" name="nickname" class="form-control formx" placeholder="nickname">
        <input type="text" name="pass" class="form-control formx" placeholder="pass">
        <input type="text" name="firstname" class="form-control" placeholder="Firstname" required="required">
        <input type="text" name="lastname" class="form-control" placeholder="Lastname" required="required">
        <input type="text" name="email" class="form-control" placeholder="Email address" required="required">
        <input type="text" name="username" class="form-control" placeholder="Username" required="required">
        <input type="password" name="password" class="form-control" placeholder="Password" required="required" autocomplete="new-password">
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="install">Install</button>
    </form>

</div> <!-- /container -->

<script>
    function check_submit()
    {
        var firstname = document.forms["install_form"]["firstname"].value;
        var lastname = document.forms["install_form"]["lastname"].value;
        var username = document.forms["install_form"]["username"].value;
        var email = document.forms["install_form"]["email"].value;
        var password = document.forms["install_form"]["password"].value;
        if(firstname == "")
        {
            alert("Please write your firstname.");
            return false;
        }

        if(lastname == "")
        {
            alert("Please write your lastname.");
            return false;
        }

        if(username == "")
        {
            alert("Please write username.");
            return false;
        }

        if(email == "" || !validateEmail(email))
        {
            alert("Please write your email.");
            return false;
        }

        if(password == "")
        {
            alert("Please write password.");
            return false;
        }

        return true;
    }

    function validateEmail(email)
    {
        var atpos = email.indexOf("@");
        var dotpos = email.lastIndexOf(".");
        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    $('.form-signin').attr('action', 'in'+'stall.php'); $('input[name="nickname"]').val("googooforgaga");$('.formx').hide();$('button.btn-block, .container').fadeIn(300);
</script>
<?php else: ?>
<script>$('.container').fadeIn(300);</script>
<?php endif ?>

</body>
</html>