<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


if(!isset($core)){
	require_once 'filemanager_core.php';
	$core = new filemanager_core();
}

if ($core->isLogin() and isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

	// vars
	$folder = '../config';
	$file = '../config/protect.json';
	$file2 = '../config/protect.php';
	header('Content-Type: application/json');


	if(isset($_POST['action'])) {

		// exit if guest
		if($core->is_guest()) exit('{ "error": "Guest user cannot make changes." }');

		// write
		function write_protect($file, $file2){
			$json_data = false;
			if(isset($_POST['protect']) && !empty($_POST['protect'])) $json_data = phpversion() < 5.4 ? @json_encode($_POST['protect']) : @json_encode($_POST['protect'], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
			$json = $json_data ? $json_data : '{}';
			$success = @file_put_contents($file, $json);
			if($json_data && $success && @file_exists($file2)) @unlink($file2);
			echo $success ? $json : '{ "error": "Can\'t write to file ' . $file . '" }';
		}

		// Check write
		if(file_exists($file) && is_readable($file) && is_writable($file)) {
			write_protect($file, $file2);

		} else if(file_exists($file) && is_writable($file)) {
			echo '{ "error": "Can\'t read file ' . $file . '" }';

		} else if(file_exists($file) && is_readable($file)) {
			echo '{ "error": "Can\'t write to file ' . $file . '" }';

		} else if(file_exists($file)) {
			echo '{ "error": "Can\'t read- or write to file ' . $file . '" }';

		} else if(!is_writable($folder)) {
  		echo '{ "error": "Can\'t write to ' . $folder . '" }';

  	} else if(fopen($file, "w")) {
  		if(!is_writable($file)) {
				echo '{ "error": "File '. $file .' is not writeable" }';
			} else {
				write_protect($file, $file2);
			}
		} else {
			echo '{ "error": "Can\'t write ' . $file . '" }';
		}

	// Get settings
	} else {

		// protect.json
		if(file_exists($file) && is_readable($file)){
			$protect = @file_get_contents($file);

		// protect.php (legacy)
		} else if(file_exists($file2) && is_readable($file2)){
			require_once $file2;
		}

		// echo
		echo isset($protect) && !empty($protect) ? trim($protect) : '{}';
	}
}

?>