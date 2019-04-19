<?php

// core
require 'filemanager_core.php';
$core = new filemanager_core();

# vars
$success = 'Menu refreshed!';
$error_msg = 'Cannot write to /_cache/pages/menu';
$denied = '<strong>Permission denied</strong><br>You need to be logged in to access this function.';

if($core->isLogin()){

	// exit if guest
	if($core->is_guest()) exit('{ "error": "Guest user cannot make changes." }');

	chdir('../');

	# vars
	$dir = './_cache/pages';
	$error = false;

	# include
	include './app/menu.inc.php';

	# writeable
	if(file_exists($dir.'/menu') && !is_writable($dir.'/menu')) {
		$error = $error_msg;
	} else if(!is_dir($dir)) {
    if(false === @mkdir($dir, 0777, true) && !is_dir($dir)) $error = $error_msg;
    if(!is_writable($dir)) $error = $error_msg;
  } else if(!is_writable($dir)){
  	$error = $error_msg;
  }

  # $dir
  $dir = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/') . '/';

  # touch
	if(!touch('content')) {
		echo $core->touchme_error();

	// write menu
	} else {

		// include helpers and create folders ob
		include './app/helpers.inc.php';
		Helpers::get_folders();

		# json
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

			# json header
			header('Content-Type: application/json');

			# write menu
			if($error === false && Menu::write_menu($dir)) {
				echo '{ "success": true }';
			} else {
				echo '{ "error": "' . $error . '" }';
			}

		# direct access
		} else {
			if($error === false && Menu::write_menu($dir)) {
				echo $success;
			} else {
				echo $error;
			}
		}
	}

# deny access
} else {
	echo $denied;
}

?>