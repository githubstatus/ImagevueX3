<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($core)){
	require_once 'filemanager_core.php';
	$core = new filemanager_core();
}

if($core->isLogin() and isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

	// JSON output
	header('Content-Type: application/json; charset=utf-8');

	// exit if guest
	if(!isset($_POST['get_settings']) && $core->is_guest()) exit('{ "error": "Guest user cannot make changes." }');

	// Vars
	$config_folder = '../config';
	$config_user = '../config/config.user.json';
	$config_default = '../app/config.defaults.json';

	// set iptc value only if $file[val] isset and assigned value is not same as existing value.
	function x3_set_iptc($file, $iptc, $str, $const){
		if(isset($file[$str]) && $iptc->fetch($const) != $file[$str]) {
			$iptc->set($const, $file[$str]);
			return 1;
		}
		return 0;
	}

	// set iptc
	function set_iptc($files){

		// filter jpg type files and path is defined
		$files = array_filter($files, function($val){
			return isset($val['path']) && in_array(strtolower(pathinfo($val['path'], PATHINFO_EXTENSION)), array('jpg', 'jpeg', 'pjpeg'));
		});

		// return if $files is empty
		if(empty($files)) return;

		// require IPTC
		require 'iptc.php';

		// vars
		$success = 0;
		//$count = count($files);
		$write = 0;

		// loop files
		foreach($files as $file) {

			$path = $file['path'];

			// continue if !file_exists or !is_writable
			if(!file_exists($path) || !is_writable($path)) continue;

			// start iptc
			$iptc = new Iptc($path);

			// write various values
			$write += x3_set_iptc($file, $iptc, 'hidden', Iptc::X3_HIDDEN);
			$write += x3_set_iptc($file, $iptc, 'title', Iptc::OBJECT_NAME);
			$write += x3_set_iptc($file, $iptc, 'description', Iptc::CAPTION);
			$write += x3_set_iptc($file, $iptc, 'link', Iptc::X3_LINK);
			$write += x3_set_iptc($file, $iptc, 'target', Iptc::X3_LINK_TARGET);
			$write += x3_set_iptc($file, $iptc, 'index', Iptc::X3_INDEX);

			// store reference date
			if(isset($file['date']) && !empty($file['date'])) {
				$reference_date = $iptc->fetch(Iptc::REFERENCE_DATE);
				if(empty($reference_date)) $iptc->set(Iptc::REFERENCE_DATE, $file['date']);
			}

			// write
			//$iptc->write()
			if(!$write || $iptc->write()) $success ++;
		}

		return $success;
	}

	// Function to filter differences in defaults vs save
	function arrayRecursiveDiff($aArray1, $aArray2) {
	  $aReturn = array();
	  foreach ($aArray1 as $mKey => $mValue) {
	    if (array_key_exists($mKey, $aArray2)) {
	      if (is_array($mValue)) {
	        $aRecursiveDiff = arrayRecursiveDiff($mValue, $aArray2[$mKey]);
	        if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
	      } else {
	        if ($mValue != $aArray2[$mKey]) {
	          $aReturn[$mKey] = $mValue;
	        }
	      }
	    } else {
	      $aReturn[$mKey] = $mValue;
	    }
	  }
	  return $aReturn;
	}

	// Return current settings
	if(isset($_POST['get_settings'])) {

		// Clone settings
		$clone = new ArrayObject(X3Config::$config);

		// exclude sensitive data (optional USERX server enironment)
		if(X3Config::$config["userx"]){
			if(@file_exists('../../../panel_settings_exclude.php')){
				require('../../../panel_settings_exclude.php');
			} else if(@file_exists('../../panel_settings_exclude.php')){
				require('../../panel_settings_exclude.php');
			}
		}

		// echo
		echo json_encode($clone);

	// Save page settings
	} else if(isset($_POST['page_settings']) && isset($_POST['path'])) {

		if(!$core->touchme()){
			echo $core->touchme_error();
		} else {

			// save iptc to jpg
			if(isset($_POST['files']) && !empty($_POST['files']) && is_array($_POST['files'])){
				set_iptc($_POST['files']);
			}

			// folders custom sorting
			if(isset($_POST['folders']) && !empty($_POST['folders'])) X3::merge_folders(X3::json_decode($_POST['folders']));

			// vars
			$save_path = str_replace('../../content','../content', $_POST['path']);
			$page = X3::json_decode($_POST['page_settings']);

			// If inject setting
			if(isset($_POST['inject']) && $_POST['inject']) {
				$current = array();
				if(file_exists($save_path)){
					$current_content = file_get_contents($save_path);
					if(!empty($current_content)) $current = json_decode($current_content, TRUE);
				}
				$diff = array_replace_recursive($current, $page);

			// Page settings
			} else {
				$diff = arrayRecursiveDiff($page, X3Config::$config);
			}

			$save = (phpversion() < 5.4) ? json_encode($diff) : json_encode($diff, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

			// Save it!
			if(!file_exists($save_path)) {
				if(fopen($save_path, "w")){
					if(!is_writable($save_path)) {
						echo '{ "error": "File '. $save_path .' is not writeable" }';
					} else {
						if(file_put_contents($save_path, $save)){
							echo '{ "success": true }';
						} else {
							echo '{ "error": "Can\'t save to file ' . $save_path . '." }';
						}
					}
				} else {
					echo '{ "error": "Can\'t create ' . $save_path . '" }';
				}
			} else if(file_put_contents($save_path, $save)){
				echo '{ "success": true }';
			} else {
				echo '{ "error": "Can\'t save to file ' . $save_path . '." }';
			}
		}

	// Save settings
	} else if(isset($_POST['settings'])) {

		// Render config
		function render($config_user, $config_default){

			// Save user config (only differences from default)
			$default = json_decode(file_get_contents($config_default), TRUE);
			$user = X3::json_decode($_POST['settings']);
			$diff = (object)arrayRecursiveDiff($user, $default);

			if(isset($diff->toolbar['items'])) $diff->toolbar['items'] = preg_replace(array('/,\r\n    }/', '/,\r\n  ]/'), array("\r\n    }", "\r\n  ]"), $diff->toolbar['items']); // minify and fix oprhan commas for toolbar items string
			$save = (phpversion() < 5.4) ? json_encode($diff) : json_encode($diff, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

			// Write data
			if(file_put_contents($config_user, $save)){
				echo '{ "success": true }';
			} else {
				echo '{ "error": "Can\'t save config." }';
			}
		}

		if(!$core->touchme()){
			echo $core->touchme_error();
		} else {
			// Make sure config is writeable
			if(!file_exists($config_folder)) {
				echo '{ "error": "Folder ' . $config_folder . ' does not exist" }';
			} else if(!file_exists($config_user)) {
				if(!is_writable($config_folder)) {
					echo '{ "error": "Folder ' . $config_folder . ' is not writeable" }';
				} else if(fopen($config_user, "w")){
					if(!is_writable($config_user)) {
						echo '{ "error": "File '. $config_user .' is not writeable" }';
					} else {
						render($config_user, $config_default);
					}
				} else {
					echo '{ "error": "Failed to create '. $config_user .'" }';
				}
			} else if(!is_writable($config_user)) {
				echo '{ "error": "File '. $config_user .' is not writeable" }';
			} else {
				render($config_user, $config_default);
			}
		}

	// Save settings
	} else if(isset($_POST['iptc'])) {

		if(isset($_POST['files']) && !empty($_POST['files']) && is_array($_POST['files'])){

			// set iptc success
			if(set_iptc($_POST['files'])){

				// touch
				if(!$core->touchme()){
					echo $core->touchme_error();

				// success
				} else {
					//$success = $count === $success ? 'Successfully'
					echo '{ "success": true }';
				}

			} else {
				echo '{ "success": false, "error": "Can\'t write IPTC data to file. " }';
			}

		// empty $_POST['file'] or don't exist
		} else {
			echo '{ "success": false, "error": "empty files array" }';
		}

	// Save settings
	} else if(isset($_POST['folders'])) {

		// get json custom array
		$json = X3::json_decode($_POST['folders']);

		// write
		if(!$core->touchme()){
			echo $core->touchme_error();
		} else {
			echo X3::merge_folders($json) ? '{ "success": true }' : '{ "success": false, "error": "Could not write to content/folders.json" }';
		}



	/*} else if(isset($_POST['mailtest'])) {

		//SMTP needs accurate times, and the PHP time zone MUST be set
		//This should be done in your php.ini, but this is how to do it if you don't have access to that
		date_default_timezone_set('Etc/UTC');

		require 'filemanager_assets/PHPMailer/PHPMailerAutoload.php';

		//Create a new SMTP instance
		$smtp = new SMTP;

		//$smtp->SMTPAuth = true;
		//$smtp->SMTPSecure = 'tls'; // tls, ssl or empty

		//Enable connection-level debug output
		//$smtp->do_debug = SMTP::DEBUG_CONNECTION;

		try {
		//Connect to an SMTP server
		    if ($smtp->connect($_POST['host'], $_POST['port'])) {
		        //Say hello
		        if ($smtp->hello($_POST['host'])) { //Put your host name in here
		            //Authenticate
		            if ($smtp->authenticate($_POST['username'], $_POST['password'])) {
		                //echo "Connected ok!";
		                echo '{ "success": "Connected!" }';
		            } else {
		                throw new Exception('Authentication failed: ' . $smtp->getLastReply());
		            }
		        } else {
		            throw new Exception('HELO failed: '. $smtp->getLastReply());
		        }
		    } else {
		        throw new Exception('Connect failed');
		    }
		} catch (Exception $e) {
		    //echo 'SMTP error: '. $e->getMessage(), "\n";
		    echo '{ "error": ' . json_encode($e->getMessage()) . ' }';
		}
		//Whatever happened, close the connection.
		$smtp->quit(true);*/




	} else {
  	echo '{ "error": "No request parameters?" }';
	}
}

