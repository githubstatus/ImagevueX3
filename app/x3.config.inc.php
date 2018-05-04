<?php

Class X3Config {

	public static $config;

	function __construct() {
		$root = dirname(dirname(__FILE__));
		$config_user_path =  $root . '/config/config.user.json';
		$config_default_path = $root . '/app/config.defaults.json';
		$config_global_path = dirname($root).'/global.json';
		$config_global_parent_path = dirname(dirname($root)).'/global.json';
		$user = array();
		$global = array();

		// DEFAULT json object
	  $default = json_decode(file_get_contents($config_default_path), TRUE);

		// USER json object
		if(file_exists($config_user_path)){
			$user_content = file_get_contents($config_user_path);
			if(!empty($user_content)) $user = json_decode($user_content, TRUE);
		}

		// get basedir
		$basedir_str = ini_get('open_basedir');

	  // GLOBAL json object
		if(empty($basedir_str) && file_exists($config_global_path)){
			$global_content = file_get_contents($config_global_path);
			if(!empty($global_content)) $global = json_decode($global_content, TRUE);
		}
		// GLOBAL json object
	  if(empty($basedir_str)){
	  	$global_content = '';
	  	if(file_exists($config_global_path)){
				$global_content = file_get_contents($config_global_path);
			} else if(file_exists($config_global_parent_path)){
				$global_content = file_get_contents($config_global_parent_path);
			}
			if(!empty($global_content)) $global = json_decode($global_content, TRUE);
	  }

	  // Output
	  self::$config = array_replace_recursive($default, $user, $global);
	}
}

new X3Config();




/*function getX3Config(){

	// Paths
	$root = dirname(dirname(__FILE__));
	$config_user_path =  $root . '/config/config.user.json';
	$config_default_path = $root . '/app/config.defaults.json';
	$config_global_path = dirname($root).'/global.json';
	$config_global_parent_path = dirname(dirname($root)).'/global.json';
	$user = array();
	$global = array();

	// DEFAULT json object
  $default = json_decode(file_get_contents($config_default_path), TRUE);

	// USER json object
	if(file_exists($config_user_path)){
		$user_content = file_get_contents($config_user_path);
		if(!empty($user_content)) $user = json_decode($user_content, TRUE);
	}

	// get basedir
	$basedir_str = ini_get('open_basedir');

  // GLOBAL json object
	if(empty($basedir_str) && file_exists($config_global_path)){
		$global_content = file_get_contents($config_global_path);
		if(!empty($global_content)) $global = json_decode($global_content, TRUE);
	}
	// GLOBAL json object
  if(empty($basedir_str)){
  	$global_content = '';
  	if(file_exists($config_global_path)){
			$global_content = file_get_contents($config_global_path);
		} else if(file_exists($config_global_parent_path)){
			$global_content = file_get_contents($config_global_parent_path);
		}
		if(!empty($global_content)) $global = json_decode($global_content, TRUE);
  }

  // COMBINED
  $config = array_replace_recursive($default, $user, $global);

  // Output
  return $config;

}*/

?>