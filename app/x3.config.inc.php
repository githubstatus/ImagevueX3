<?php

Class X3Config {

	public static $config;

	function get_json($path){
		if(!file_exists($path)) return array();
		$content = @file_get_contents($path);
		if(empty($content)) return array();
		$json = @json_decode($content, TRUE);
		return empty($json) ? array() : $json;
	}

	function __construct() {
		$root = dirname(__DIR__);

		// DEFAULT json object
	  $default = self::get_json($root . '/app/config.defaults.json');

		// USER json object
		$user = self::get_json($root . '/config/config.user.json');

		// userx
		$userx = isset($_SERVER['USERX']) ? $_SERVER['USERX'] : false;

		// userx enabled
		if($userx){
			$global_parent_config = self::get_json(dirname($root) . '/global.json');
			$global_parent_parent_config = self::get_json(dirname(dirname($root)) . '/global.json');
			self::$config = array_replace_recursive($default, $user, $global_parent_parent_config, $global_parent_config);
		} else {
			self::$config = array_replace_recursive($default, $user);
		}

		// userx to config
	  self::$config["userx"] = $userx;
	}
}

new X3Config();

?>