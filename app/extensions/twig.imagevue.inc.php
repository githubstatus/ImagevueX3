<?php

//require_once Config::$app_folder.'/parsers/Twig/ExtensionInterface.php';
//require_once Config::$app_folder.'/parsers/Twig/Extension.php';

// Check server protocol, also checking Cloudflare SSL
/*$server_protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? "https://" : "http://";
define('PROTOCOL', $server_protocol);*/

// Imagevue TWIG extensions
class Imagevue_Twig_Extension extends Twig_Extension {

  var $sortby_value;

  static $data_js_paths = array();

  public function getName() {
    return 'X3 Photo Gallery // www.photo.gallery';
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
      'get_default_preview_image' => new Twig_Function_Method($this, 'get_default_preview_image'),
      'pano_params' => new Twig_Function_Method($this, 'pano_params')
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
    return Helpers::attribute_friendly($str);
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

  /*{
    ["width"]=>string(4) "4096"
    ["height"]=>string(4) "2048"
    ["params"]=>string(89) "option=true&tilesize=2048&width=1024,3072,6144,12288,23552&height=404,1208,2416,4832,9260"
    ["url"]=>string(48) "./content/examples/plugins/panorama/1.church.jpg"
    ["file_name"]=>string(12) "1.church.jpg"
  }*/

  // pano convert path
  private function convert_path($path, $dir){
    $path = trim($path, './');
    if(strpos($path, 'http') === 0) return $path;
    if(strpos($path, 'content/') === 0) return './' . $path;
    if(strpos($path, '/content/') > -1){
      $arr = explode('/content/', $path, 2);
      return './content/' . $arr[1];
    }
    return $dir . '/' . $path;
  }

  // pano convert path
  private function convert_path_out($path, $assetspath){
    if(strpos($path, './content/') !== 0) return $path;
    return $assetspath . trim($path, '.');
  }

  // pano params
  function pano_params($image, $assetspath){

    // vars 
    $width = intval($image['width']);
    $height = intval($image['height']);
    $file_name = strtolower($image['file_name']);

    // params
    $params = array();
    //if(isset($image['params']) && !empty($image['params'])) parse_str($image['params'], $params);
    if(isset($image['params']) && !empty($image['params'])) parse_str(html_entity_decode($image['params']), $params);

    // id
    $params['id'] = $image['id'] ? $image['id'] : $image['file_name'];

    /*
    date: 1538474197
    file_name: "2.yosemite.jpg"
    id: "yosemite"
    name: "yosemite"
    title: "nada"
    description: "nada"
    url: "./content/examples/plugins/panorama/2.yosemite.jpg"
    exif
      exif.longtitude exif.latitude
    */

    // type param detection
    $type = false;
    if(isset($params['type'])){
      $type = in_array($params['type'], array('equirect', 'cube', 'flat')) ? $params['type'] : false;
      if(!$type) return ' data-panorama-error="Invalid panorama type [' . $params['type'] . ']"';
    }

    // multi vars
    $multi_dir = join('.', explode('.', $image['url'], -1));
    $is_multi = $type !== 'equirect' && (isset($params['path']) || is_dir($multi_dir));

    // detect type
    if(!$type){
      if(strpos($file_name, 'flat') !== false){
        $type = 'flat';
      } else if(strpos($file_name, 'cube') !== false){
        $type = 'cube';
      } else if(strpos($file_name, 'equirect') !== false || ($width >= 4096 && $width/$height === 2 && !$is_multi)){
        $type = 'equirect';
      }
    }

    // flat or cube
    if($type !== 'equirect' && $is_multi){

      // get path
      if(isset($params['path'])){
        $path = self::convert_path($params['path'], dirname($image['url']));
        $is_content_path = strpos($path, './content/') === 0 ? true : false;
        if($is_content_path && !is_dir($path)) return ' data-panorama-error="Invalid panorama path"';
      } else {
        $path = $multi_dir;
        $is_content_path = true;
      }
      $params['path'] = self::convert_path_out($path, $assetspath);

      // flat
      if($type === 'flat' || isset($params['width'])){

        // error no width or height array
        if(!isset($params['width']) || !isset($params['height'])) return ' data-panorama-error="Missing [width] or [height] array for flat panorama."';

        // Convert to levels for flat
        $width_array = explode(',', $params['width']);
        $height_array = explode(',', $params['height']);
        if(count($width_array) === count($height_array)){
          $params['levels'] = array_map(function($w, $h){
            return array('width' => $w, 'height' => $h);
          }, $width_array, $height_array);
          unset($params['width']);
          unset($params['height']);

        // width/height does not match
        } else {
          return ' data-panorama-error="Width array count does not match height array count."';
        }

        // type flat
        $params['type'] = 'flat';

      // cube
      } else {

        // data.js stored
        $data_js = isset(self::$data_js_paths[$path]) ? self::$data_js_paths[$path] : array();

        // check for data.js
        if(empty($data_js)){

          // check if data.js file exists
          if(@file_exists($path . '/data.js')){
            $data_js['path'] = $path;
          } else if(@file_exists($path . '/app-files/data.js')){
            $data_js['path'] = $path . '/app-files';
          }

          // get data.js
          if(isset($data_js['path'])){
            $data_js_content = @file_get_contents($data_js['path'] . '/data.js');
            $begin = strpos($data_js_content, '{');
            $json_string = substr($data_js_content, $begin, strrpos($data_js_content, '}') + 1 - $begin);
            $data_js['data'] = json_decode($json_string, true);
            self::$data_js_paths[$path] = $data_js;
          }
        }

        // data from data.js exists
        if(!empty($data_js)){

          // Default scene_index 0
          $scene_index = 0;

          // Get scene index from scene_id
          if(isset($params['scene_id'])){
            foreach($data_js['data']['scenes'] as $index => $val) {
              if($val['id'] === $params['scene_id'] || $val['name'] === $params['scene_id']) {
                $scene_index = $index;
                break;
              }
            }

          // Get scene index from scene_index
          } else if(isset($params['scene_index']) && $params['scene_index'] < count($data_js['data']['scenes'])){
            $scene_index = $params['scene_index'];
          }

          // Get scene index from name
          if($scene_index === 0){
            foreach($data_js['data']['scenes'] as $index => $val) {
              if($val['name'] === basename($multi_dir)) {
                $scene_index = $index;
                break;
              }
            }
          }

          // assign scene from scene_index
          $scene = $data_js['data']['scenes'][$scene_index];

          // params
          $params['path'] = self::convert_path_out($data_js['path'] . '/tiles/' . $scene['id'], $assetspath);
          $params['levels'] = $scene['levels'];
          foreach($scene['initialViewParameters'] as $key => $value) {
            if(!isset($params[$key])) $params[$key] = $value;
          }
          $params['face_size'] = $scene['faceSize'];

        // else get levels
        } else if(!isset($params['levels']) && $is_content_path) {

          $path_dirs = @glob($path . '/*', GLOB_NOSORT|GLOB_ONLYDIR);
          if(!$path_dirs || !count($path_dirs)) return ' data-panorama-error="Cannot find any dirs inside ' . $path . '"';
          $params['levels'] = count($path_dirs);

        // error no levels
        } else if(!isset($params['levels'])){
          return ' data-panorama-error="Cannot locate assigned path [' . $path . ']. If the path is remote, [levels] parameter must be provided."';
        }

        // type cube
        $params['type'] = 'cube';
      }

    // equirect or nope
    } else {

      // vars
      $source = false;
      $exists = false;
      $extension = pathinfo($image['url'], PATHINFO_EXTENSION);
      $large = $multi_dir . '_large.' . $extension;

      // source param
      if(isset($params['source'])) {
        $source = self::convert_path($params['source'], dirname($image['url']));
        $exists = strpos($source, './content/') === 0 && file_exists($source) ? true : false;

      // _large
      } else if(file_exists($large)){
        $source = $large;
        $exists = true;
      }

      // source get width / height
      if($source){
        if(isset($params['width'])){
          $width = intval($params['width']);
          $height = isset($params['height']) ? intval($params['height']) : round($width / 2);
        } else if(isset($params['height'])){
          $height = intval($params['height']);
          $width = isset($params['width']) ? intval($params['width']) : round($height * 2);
        } else if($exists){
          list($width, $height) = @getimagesize($source);
        } else {
          $width = 4096;
          $height = 2048;
          //return ' data-panorama-error="Cannot locate assigned source [' . $source . ']. If the source is remote, [width] and [height] parameters must be provided."';
        }

      // is self
      } else {
        $source = $image['url'];
      }

      // not 2:1
      if($width/$height != 2) return ' data-panorama-error="Cannot detect equirectangular panorama. Image is not 360/180 2:1 ratio."';

      // add source_4096 size if $width > 4096 and $medium exists
      if($width > 4096 && !isset($params['source_4096'])){
        $medium = $multi_dir . '_4096.' . $extension;
        if(file_exists($medium)) $params['source_4096'] = self::convert_path_out($medium, $assetspath);
      }

      // type equirect
      $params['type'] = 'equirect';
      $params['width'] = $width;
      $params['height'] = $height;
      $params['source'] = self::convert_path_out($source, $assetspath);
    }

    // convert booleans
    $params = array_map(function($val){
      return $val === 'true' ? true : ($val === 'false' ? false : $val);
    }, $params);

    // return data json
    return ' data-panorama="' . htmlspecialchars(json_encode($params, JSON_NUMERIC_CHECK)) . '"';
    //return ' data-panorama="' . http_build_query($params) . '"';
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
