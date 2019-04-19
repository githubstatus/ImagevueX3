
<?php

$login_required = true;

// login required
if($login_required){
	if(!isset($core)){
		require_once 'filemanager_core.php';
		$core = new filemanager_core();
	}

	if(!$core->isLogin()) exit('<strong>Forbidden</strong><br>You need to <a href=".">login</a> to use the X3 DB checker.');
}

$css_path = dirname(dirname($_SERVER['PHP_SELF']));
if(substr($css_path, -1) !== '/') $css_path .= '/';

# Check if POSTED data from ajax
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_REFERER']) && stripos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) !== false) :

# Function to add item to output msg
function addItem($status, $title, $description){
	$str = "<div class=\"x3-diagnostics-item x3-diagnostics-".$status."\">";
	if(!empty($title)) $str .= "<strong>".$title."</strong>";
	$str .= "<div class=x3-diagnostics-description>".$description."</div></div>";
	return $str;
}

# output $warning
$warning = (string)"";

# Check database panel login
if(function_exists('mysqli_connect')){

	# DB vars
	$dbname = isset($_POST['db_name']) ? $_POST['db_name'] : null;
	$dbuser = isset($_POST['db_username']) ? $_POST['db_username'] : null;
	$dbpass = isset($_POST['db_password']) ? $_POST['db_password'] : null;
	$dbhost = isset($_POST['db_host']) ? $_POST['db_host'] : null;

	# Check DB connection
	# https://www.daniweb.com/programming/web-development/code/434480/using-phpmysqli-with-error-checking
	$connection = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	//var_dump($connection);

	# Connection error
	if($connection->connect_errno) {
		$msg = (string)$connection->connect_error;

		# Specifically failed DB HOST
		if(strtolower($msg) === 'no such file or directory'){
			$warning .= addItem("danger", "Database HOST connection fail", "Failed to connect to Database HOST <strong>\"" . $dbhost . "\"</strong> (" . $msg . ")");

		# Generic DB connection error
		} else {
			$warning .= addItem("danger", "Database connection fail", "Failed to connect to Database, with given error: <strong>" . $msg . "</strong>");
		}

	# Although connected to DB host, DB name is empty or undefined
	} else if(empty($dbname)){
		$warning .= addItem("warning", "Missing Database Name", "Successfully connected to database host, but database name is undefined or empty.");

	# Connection to DB success
	} else {

		# Successfully connected to DB
		$warning .= addItem("success", "Database Connection OK!", "Successfully connected to database <strong>" . $dbname . "</strong>.");

		# [optional] Check integrity of specific db (checks if X3 panel is installed)
		$query = 'SELECT * FROM `filemanager_db` ORDER BY `id` LIMIT 1';
		$result = $connection->query($query);
		$uninstalled = addItem("warning", "X3 Panel not installed", "Although successfully connected to the database \"" . $dbname . "\", you do not seem to have installed the X3 panel for this database. Run the <a href=./install/ target=_blank>X3 Panel Install</a> script.");
		if(!$result) {
			$warning .= $uninstalled;
		} else {
			$fetch = $result->fetch_object();
			if(empty($fetch)) {
				$warning .= $uninstalled;
			}
			$result->close();
		}

		# close connection
		$connection->close();
	}

# Wooops, no mysqli interface?
} else {
	$warning .= addItem("danger", "Missing mysqli_connect function", "Your server seems to be missing the <a href=http://php.net/manual/en/mysqli.installation.php target=_blank>mysqli extension</a>, necessary for connecting to databases.");
}

# output diagnosis
echo $warning;

# Output initial html if not POST
else: 

# Display ALL errors to detect any server issues
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
?>

<head>
<title>X3 Database Connection checker</title>
<meta name="robots" content="noindex, nofollow">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
<link href="<?php echo $css_path ?>app/public/css/diagnostics.css?v=3.25.0" rel="stylesheet" type="text/css">
<style><!--
.x3-diagnostics-wrapper {
	max-width: 500px;
}
--></style>
</head>
<body>
	<div class=x3-diagnostics>
		<h1>X3 Database Connection Checker</h1>
		<div class=x3-diagnostics-wrapper>
			<div class=report><div class="x3-diagnostics-item x3-diagnostics-neutral" style="text-align: center;">Database connection diagnostics will appear here.</div></div>
			<div class=form-container></div>
		</div>
	</div>
<script>

// Vars
var form_container = $('.form-container');
		report = $('.report'),
		mytimer = null;

// Inject the input
form_container.html('<label for="db_host">Database Host</label><input type="text" name="db_host" id="db_host" required><label for="db_username">Database Username</label><input type="text" name="db_username" id="db_username" required><label for="db_password">Database Password</label><input type="text" name="db_password" id="db_password" required><label for="db_name">Database Name</label><input type="text" name="db_name" id="db_name" required>');

$('body').one('touchstart mousemove', function(e) {
	form_container.append('<button>Check Connection</button>');

	// define button
	var button = form_container.children('button');

	// success function, regardless of output
	function reply(msg){
		$(window).scrollTop(0);
		report.css('display', 'none').html($.trim(msg)).fadeIn(300);
		button.text('Check Connection');
		$('body').removeClass('checking');
		form_container.find('input, button').attr('disabled', false).removeAttr('disabled');
		clearInterval(mytimer);
	}

	// button click, disable if already checking
	button.not('[disabled]').on('click', function(event) {
		event.preventDefault();

		// Vars
		var populated = true,
				post = {},
				timer = 9;

		// Loop input items, validate and make sure they are all populated
		form_container.children('input').each(function(index) {
			var input = $(this);
			if(input.val()) {
				post[input.attr('name')] = input.val();
			} else {
				input.addClass('error');
				setTimeout(function(){ input.removeClass('error') }, 1000);
				populated = false;
			}
		});

		// Only post form if all items are populates
		if(populated){

			// Set some visual cues
			$('body').addClass('checking');
			form_container.find('input, button').attr('disabled', true);
			report.html('<div class="x3-diagnostics-item x3-diagnostics-neutral" style="text-align: center;">Please wait ...</div>');
			button.text('Connecting ... ' + timer);
			clearInterval(mytimer);
			mytimer = setInterval(function(){
				timer --;
				button.text('Connecting ... ' + timer);
				if(timer <= 0) clearInterval(mytimer);
			}, 1000);

			// POST check!
			$.ajax({
	      type: 'POST',
	      url: 'db_check.php',
	      data: post,
	      dataType: 'html',
	      timeout: 9000,
	      success: function(data) {
					reply(data);
	      },
	      error: function(request, status, err) {
	      	reply('<div class="x3-diagnostics-item x3-diagnostics-warning"><strong>Database Connection Timeout</strong><div class="x3-diagnostics-description">Connection timeout when trying to connect to database host <strong>' + post.db_host + '</strong>.</div></div>');
	      }
	    });
		}
	});
});
</script>
</body>
<?php endif ?>