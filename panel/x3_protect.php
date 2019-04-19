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
	$file = '../config/protect.php';
	header('Content-Type: application/json');

	if(isset($_POST['protect'])) {

		// exit if guest
		if($core->is_guest()) exit('{ "error": "Guest user cannot make changes." }');

		// write
		function write_protect($file){
			$ob = get_magic_quotes_gpc() ? json_decode(stripslashes($_POST['protect']), TRUE) : json_decode($_POST['protect'], TRUE);
			$json = (phpversion() < 5.4) ? json_encode($ob) : json_encode($ob, JSON_PRETTY_PRINT);
			$content = '<?php'.PHP_EOL.'$protect = \''.PHP_EOL.$json.PHP_EOL.'\';'.PHP_EOL.'?>';
			if(file_put_contents($file, $content)){
				echo json_encode($ob);
			} else {
				echo '{ "error": "Can\'t write to file ' . $file . '" }';
			}
		}

		// Check write
		if(file_exists($file) && is_readable($file) && is_writable($file)) {
			write_protect($file);

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
				write_protect($file);
			}

		} else {
			echo '{ "error": "Can\'t write ' . $file . '" }';
		}

	// Get settings
	} else {

		if(file_exists($file) && is_readable($file)) {
	  	require_once $file;
			echo $protect;
		} else if(file_exists($file)) {
			echo '{ "error": "Can\'t read file ' . $file . '" }';
		} else {
			$default_protect = '{"access":{"examples\/other\/password\/":{"username":"guest","password":"guest","users":["demouser1"]},"some\/folder\/":{"users":["demouser1","demouser2"]}},"users":{"superuser*":"superman","demouser1":"batman","demouser2":"hulk"}}';
			echo $default_protect;
		}

	}
}






?>