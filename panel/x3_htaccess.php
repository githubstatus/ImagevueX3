<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


if(!isset($core)){
	require_once 'filemanager_core.php';
	$core = new filemanager_core();
}

if ($core->isLogin() and isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

	// vars
	$file = stripos($_SERVER['SERVER_SOFTWARE'], 'IIS') !== false ? '../web.config' : '../.htaccess';

	if(isset($_POST['action']) && $_POST['action'] == 'load') {
		if(!file_exists($file)) {
			echo 'nofile';
		} else if(!is_readable($file)){
			echo 'noread';
		} else {
			$out = '';
			if(!is_writeable($file)) $out .= 'nowrite';
			$out .= file_get_contents($file);
			echo $out;
		}
	} else if(isset($_POST['data']) && !empty($_POST['data'])){
		if(!is_writeable($file)){
			echo 'no';
		} else if(file_put_contents($file, $_POST['data']) === false){
			echo 'no';
		} else {
			echo 'ok';
		}
	}
}


?>