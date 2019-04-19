<?php

// core
require_once 'filemanager_core.php';
$core = new filemanager_core();

// vars
$file = '../content';
$success = 'Updated!';
$error = 'Cannot update file ' . $file . '. Check file permissions!';
$denied = '<strong>Permission denied</strong><br>You need to <a href=./>login</a> to access this feature.';

// ajax
if($core->isLogin()){

	// exit if guest
	if($core->is_guest()) exit('Guest user cannot make changes.');

	if(touch($file)) {

		# echo success
		echo $success;
		flush();

		// refresh folders.json
		X3::refresh_folders();

	} else {
		echo $error;
	}
} else {
	echo $denied;
}

?>