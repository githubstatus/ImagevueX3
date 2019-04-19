<?php

//require_once Config::$app_folder.'/parsers/Twig/ExtensionInterface.php';
//require_once Config::$app_folder.'/parsers/Twig/Extension.php';

// Check server protocol, also checking Cloudflare SSL
/*$server_protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? "https://" : "http://";
define('PROTOCOL', $server_protocol);*/

// Imagevue TWIG extensions
class Imagevue_Twig_Extension extends Twig_Extension {

  var $sortby_value;

  public function getName() {
    return 'Imagevue';
  }

  public function getFilters() {
    # custom Imagevue twig filters
    return array(
      //'getcontext' => new Twig_Filter_Method($this, 'getcontext'),
      'removesettings' => new Twig_Filter_Method($this, 'removesettings'),
      'removeclasses' => new Twig_Filter_Method($this, 'removeclasses'),
      'escapecode' => new Twig_Filter_Method($this, 'escapecode'),
      'addprotocol' => new Twig_Filter_Method($this, 'addprotocol'),
      'setpath' => new Twig_Filter_Method($this, 'setpath'),
      'getfontstring'  => new Twig_Filter_Method($this, 'getfontstring'),
      'dirname'  => new Twig_Filter_Method($this, 'dirname'),
      'removeExtension'  => new Twig_Filter_Method($this, 'removeExtension'),
      'minify'  => new Twig_Filter_Method($this, 'minify'),
      'removeComments'  => new Twig_Filter_Method($this, 'removeComments'),
      'textAlign'  => new Twig_Filter_Method($this, 'textAlign'),
      'cleanData'  => new Twig_Filter_Method($this, 'cleanData'),
      'attribute_friendly'  => new Twig_Filter_Method($this, 'attribute_friendly')
    );
  }

  public function getFunctions() {
    # custom Imagevue Twig functions
    return array(
      'getimginfo' => new Twig_Function_Method($this, 'getimginfo'),
      'getSetting' => new Twig_Function_Method($this, 'getSetting'),
      'getDataOptions' => new Twig_Function_Method($this, 'getDataOptions'),
      'pluralize' => new Twig_Function_Method($this, 'pluralize'),
      'exists' => new Twig_Function_Method($this, 'exists'),
      'hasExtension' => new Twig_Function_Method($this, 'hasExtension'),
      'redirect' => new Twig_Function_Method($this, 'redirect'),
      'firstImage' => new Twig_Function_Method($this, 'firstImage'),
      'jsonSettings' => new Twig_Function_Method($this, 'jsonSettings'),
      'getMenu' => new Twig_Function_Method($this, 'getMenu'),
      'createMenu' => new Twig_Function_Method($this, 'createMenu'),
      'pageJson' => new Twig_Function_Method($this, 'pageJson'),
      'getDefault' => new Twig_Function_Method($this, 'getDefault'),
      'getSibling' => new Twig_Function_Method($this, 'getSibling'),
      'x3_glob' => new Twig_Function_Method($this, 'x3_glob'),
      'get_default_preview_image' => new Twig_Function_Method($this, 'get_default_preview_image')
    );
  }

  // get default preview image
  function get_default_preview_image(){
		$dirs = glob('./content/*index', GLOB_NOSORT|GLOB_ONLYDIR);
		if(count($dirs)) {
			$dir = current($dirs);
			if(file_exists($dir . '/preview.jpg')){
				return $dir . '/preview.jpg';
			} else {
				$files = glob($dir . '/*.*', GLOB_NOSORT);
				if(count($files)) {
					$images = array_filter($files, function($val){
			  		return in_array(strtolower(pathinfo($val, PATHINFO_EXTENSION)), array('jpg','jpeg','png','gif'));
			  	});
			  	if(count($images)) return current($images);
				}
			}
		}
  	return './app/public/images/default.png';
  }

  // x3 glob
  function x3_glob($glob, $template){
  	$items = glob($glob, GLOB_NOSORT);
  	if(!empty($items) && count($items)) {
  		$output = '';
  		foreach($items as $index => $item){
  			$output .= str_replace(array('{{index}}', '{{basename}}'), array($index + 1, basename($item)), $template);
    	}
  		return $output;
  	}
  	return false;
  }

  // javascript html attribute friendly
  function attribute_friendly($str){
    if(empty($str)) return '';
    $name = function_exists('mb_strtolower') ? mb_strtolower($str, mb_detect_encoding($str)) : strtolower($str);
    // remove 1.number and extension.jpg and lowercase
    $name = preg_replace(array('/\.[\w\d]+?$/', '/^\d+?\./'), '', $name);
    return trim(preg_replace('/\-+/', '-', str_replace(str_split(' .,()[]/"\\\'!?#`~@_$%^&*+=:;<>{}'), '-', $name)), '-');
    // preg_split('//u', ' .,()[]/"“’\\\'!?#`~@_$%^&*+=:;<>{}', -1, PREG_SPLIT_NO_EMPTY)
  }

  function cleanData($value) {
  	// remove [none]
  	$spaced = str_replace('[none]', '', $value);
  	// remove commas and multiple spaces
  	$spaced = trim(preg_replace(array('/,/', '!\s+!'), ' ', $spaced));
    // remove duplicates
    return implode(' ', array_unique(explode(' ', $spaced)));
  }

  function getSibling($path){
  	return preg_replace(array('/\d+?\./', '/\s/'), array('', '_'), htmlentities(basename($path)));
  }

  function createMenu(){
  	return Menu::check_menu(Config::$content_folder);
  }

  function getMenu(){
  	return Menu::get_menu();
	}

	// Remove text-align classes if multiple
	function textAlign($str){
		if(substr_count($str, 'text-') > 1) {
			$arr = explode(' ', $str);
			foreach($arr as $key=>$value) {
		  	if(strpos($value, 'text-') === 0){
		      unset($arr[$key]);
		      $last = $value;
		    }
		  }
		  return implode(' ', $arr) . ' ' . $last;
		} else {
			return $str;
		}
	}

  // remove html comments
	function removeComments($str){
		return preg_replace('/<!--.*?-->/s', '', $str);
	}

  function minify($value){
  	$pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';
  	return str_replace(array("\r","\n","  "), "", preg_replace($pattern, '', $value));
  }

  function removeExtension($value){
  	return preg_replace('/^[0-9]+\./', '', pathinfo($value, PATHINFO_FILENAME));
  }

  function dirname($value){
  	return dirname($value);
  }

  // Get Google font string, remove X3 junk
  function getfontstring($value){
  	$exclude = array('olark','body','paragraph','logo','menu','topbar','sidebar','header','subheader','styled','footer');
  	$arr = explode("|", $value);
  	$new = array();
  	foreach ($arr as $val) {
  		$item = explode(":", $val);
  		if(!in_array($item[0], $exclude) && !empty($item[0])) array_push($new,$val);
  	}
  	return implode("|", $new);
  }

  // Add $pre path from to permalink $value 
  function setpath($value, $pre = null) {
  	return $pre.preg_replace('/(\/+)/','/',('/'.$value));
  }

  // add http or https protocol to URL
  function addprotocol($value) {
    //return PROTOCOL.$value;
    return Stacey::$server_protocol.$value;
  }

  // data-escape method
  function escapecode($value) {
    return preg_replace_callback("/(<code data-escape>)(.*)(<\/code>)/isU", function($matches){
    	return $matches[1] . htmlentities($matches[2]) . $matches[3];
    }, $value);
  }

  // Filter: remove settings from string ('class1 class2 settings:opt1,opt2'=class1 class2')
  function removesettings($value) {
    $myarray = explode(" ", $value);
    foreach($myarray as $key=>$value) {
      if (strpos($value,":") !== false) {
        unset($myarray[$key]);
      }
    }
    return implode(" ", $myarray);
  }

  // Function: Get image info, width height etc
  function getimginfo($file){
  	$imagesize = file_exists($file) ? getimagesize($file) : null;
    return $imagesize;
  }

  // Function: Get values from setting item show:title,description,date etc. Returns setting array.
  function getSetting($value, $item){
    $myarray = explode(" ", $value);
    $myval = '';
    foreach ($myarray as &$value) {
      if (strpos($value,($item.":")) !== false) {
        $myarr = explode(":", $value);
        $myarr = array_values($myarr);
        $myval = $myarr[1];
        break;
      }
    }
    return $myval;
  }

  // Function: Get data options from module string data-options='crop:2,1;setting2:val1,val2'
  function getDataOptions($value){
    $myarray = explode(" ", $value);
    $myval = '';
    foreach ($myarray as &$value) {
      if (strpos($value,":") !== false) {
        $myval .= $value . ";";
      }
    }
    return $myval;
  }

  // Function: Pluralize string
  function pluralize($amount, $single, $plural) {
    if($amount > 1 or $amount == 0){
      $str = $plural;
    } else {
      $str = $single;
    }
    return $str;
  }

  // Function: Check if file or folder exists
  /*function exists($file) {
  	if(!empty($file)) {
      if(strpos($file,'content') === false) {
        $file = Helpers::url_to_file_path($file);
      }
      $str = file_exists($file) ? true : false;
    } else {
      $str = false;
    }
    return $str;
  }*/

  function exists($file) {
  	if(empty($file)) return false;
    if(strpos($file,'content') === false) $file = Helpers::url_to_file_path($file);
    return file_exists($file);
  }

  // check if URL has extension
  function hasExtension($val){
  	return pathinfo($val, PATHINFO_EXTENSION);
  }

  // Redirect page
  function redirect($val){
  	Helpers::redirect($val);
  }

  // Return first image in directory
  function firstImage($dir){
  	$files = glob($dir."/*.*", GLOB_NOSORT);
  	if(count($files)){
  		$images = array_filter($files, function($val){
	  		return in_array(strtolower(pathinfo($val, PATHINFO_EXTENSION)), array('jpg','jpeg','png','svg','gif'));
	  	});
	  	if(count($images)) {
	  		return trim(end($images), ".");
	  	}
	  	return false;
  	}
  	return false;
	}

	// json Settings
	function jsonSettings($page){

		// Get config
		$front = new ArrayObject(X3Config::$config);

		// Unset
		unset($front["back"]);
		unset($front["include"]);

		// Set additional vars
		$front["x3_version"] = Stacey::$version;
		//$front["site_updated"] = Helpers::site_last_modified();//$page["site_updated"];
    //$front["site_updated"] = $page["site_updated"];
    $front["site_updated"] = Helpers::site_last_modified();

    // site.json exists
    $front["site_json"] = ($front["settings"]["preload"] === 'create' || $front["settings"]["preload"] === true) && file_exists('./content/site.json');

		// set path
		//$path = dirname($_SERVER['PHP_SELF']);
		$path = str_replace("\\", '', dirname($_SERVER['PHP_SELF']));
		$front["path"] = ($path == '/') ? '' : $path;

		// Json encode
		$myjson = (phpversion() < 5.4) ? json_encode($front) : json_encode($front, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
		return $myjson;
	}

	function pageJson($title, $description, $content, $template, $id, $preview, $permalink, $file_path){

		// Some url vars
		//$base = (string)$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
		$base = (string)$_SERVER['HTTP_HOST'] . str_replace("\\", '', dirname($_SERVER['PHP_SELF']));
		$path = ($permalink == '/') ? '' : $permalink;
		$url = rtrim($base, '/') . '/' . ltrim($path, '/');

		// page or file
		if($template == 'page') {
			global $site;
			$json_page = $site["page".$file_path];
			unset($json_page["menu"]);
			if(empty($content)) unset($json_page["content"]);

			// Remove images
			foreach ($json_page as $key => $value) {
				if(strpos($key,'.') !== false) unset($json_page[$key]);
			}
		} else {
			$json_page = array();
		}

		// Set new
		$json_page["title"] = (string)$title;
		if(!empty($description)) $json_page["description"] = (string)$description;
		$json_page["type"] = (string)$template;
		$json_page["id"] = (string)$id;
		$json_page["permalink"] = str_replace($_SERVER['HTTP_HOST'], '', $url);
		$json_page["canonical"] = Stacey::$server_protocol . $url;
		$json_page["file_path"] = str_replace('./', '/', $file_path);

		if(!empty($preview)) $json_page["preview_image_full"] = (string)$preview;
		if(!empty($content)) $json_page["content"] = (string)$content;

		// Return JSON
		$myjson = (phpversion() < 5.4) ? json_encode($json_page) : json_encode($json_page, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
		return $myjson;

	}

	// getDefault
	function getDefault($title = null, $default = null, $method = 'default', $name = null) {
		if(!empty($default)) {
			if(empty($title)) {
				$val = $default;
				// make sure value is unique for image-landing pages
				if(!empty($name) && strpos($default, '{file_name') === false) {
					if($method === 'prepend') {
						$val .= ' - ' . $name;
					} else {
						$val = $name . ' - ' . $val;
					}
				}
			} else if($method === 'prepend') {
				$val = $default . ' ' . $title;
			} else if($method === 'append') {
				$val = $title . ' ' . $default;
			} else {
				$val = $title;
			}
		} else {
			$val = $title;
		}
		return trim($val);
  }

}

?>
