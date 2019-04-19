<?php

Class Helpers {

  static $file_cache;
  static $use_data = true;
  static $folders_path = './content/folders.json';
  static $folders = array();
  static $urls = array();
  static $site_updated = false;

  // refresh folders
  public static function refresh_folders(){
  	if(!file_exists(self::$folders_path) && !is_writable('./content')) return;
  	self::$folders = self::get_dirs('./content');

		// write folders.json
		if(!empty(self::$folders)) {
			$json = phpversion() < 5.4 ? json_encode(self::$folders, JSON_FORCE_OBJECT) : json_encode(self::$folders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT);
			if($json) return file_put_contents(self::$folders_path, $json);
		}
  }

  // get folders.json
	static function get_folders(){

		// load folders.json if exists
		if(file_exists(self::$folders_path)){
			$folders_data = file_get_contents(self::$folders_path);
			if(!empty($folders_data)) self::$folders = @json_decode($folders_data, TRUE);
		}

		// create new folders.json if folders empty
		if(empty(self::$folders)) self::refresh_folders();

		// create urls
		if(!empty(self::$folders)) {
			foreach (self::$folders as $key => $value) {
				if(isset($value['url'])) self::$urls[$value['url']] = './content/' . $key;
			}
		}
  }

  // get dirs
  private static function get_dirs($dir){
  	$arr = array();
  	$dirs = glob($dir . '/*', GLOB_ONLYDIR|GLOB_NOSORT);
  	if(empty($dirs)) return $arr;
		foreach($dirs as $dir){
			$content_path = str_replace('./content/', '', $dir);
			if(!$content_path || $content_path === 'custom' || strpos(basename($dir), '_') === 0) continue;
			$arr[$content_path]['url'] = preg_replace('/\d+?\./', '', $content_path);
			foreach (self::get_dirs($dir) as $key => $value) {
				$arr[$key] = $value;
			}
		}
		return $arr;
  }

  static function redirect($val) {
  	$val = trim($val);
		if(stripos($val,'http') === 0) {
  		$location = $val;
  	} else {
  		$uri = $val[0] !== '/' ? $_SERVER['REQUEST_URI'] : ''; // is relative to current path
  		$location = X3::$server_protocol . $_SERVER['HTTP_HOST'] . $uri . $val;
  	}
  	header("HTTP/1.1 301 Moved Permanently");
  	header("Location: ".$location, true, 301);
		exit();
  }

  static function file_path_to_url($file_path) {
    $url = preg_replace(array('/\d+?\./', '/(\.+\/)*content\/*/'), '', $file_path);
    return $url ? $url : 'index';
  }

  static function url_to_file_path($url, $folders_only = true) {

  	# if the url is empty, we're looking for the index page
	  $url = empty($url) ? 'index' : $url;

  	# $use_data
  	if(self::$use_data){
  		if(preg_match('/^_/', $url) || strpos($url,'/_') !== false) return false;

    	// isset
      foreach (array($url, str_replace('_',' ',$url), str_replace('_','.',$url)) as $name) {
        if(isset(self::$urls[$name])) {
          return self::$urls[$name];
        } else if(file_exists('./content/' . $name)){
          return './content/' . $name;
        }
      }
      return false;

    	/*if(isset(self::$urls[$url])){
    		return self::$urls[$url];

    	// check if content path exists
    	} else {
    		$dir_path = './content/' . $url;
    		return file_exists($dir_path) ? $dir_path : false;
    	}*/

    # old-school
  	} else {

	    $file_path = Config::$content_folder;
	    # Split the url and recursively unclean the parts into folder names
	    $url_parts = explode('/', $url);
	    foreach($url_parts as $u) {
	      # Look for a folder at the current path that doesn't start with an underscore
	      if(preg_match('/^_/', $u)) return false;
	      $matches = array_keys(Helpers::list_files($file_path, '/^(\d+?\.)?'.$u.'$/', $folders_only, false));

	      # No matches means a bad url
	      if(empty($matches)) return false;
	      else $file_path .=  '/'.$matches[0];
	    }
	    return $file_path;
  	}
  }

  // file cache
  static function file_cache($dir = false) {
    if(!empty($dir)){
    	if(!isset(self::$file_cache[$dir])) self::build_file_cache($dir);
    	return self::$file_cache[$dir];
    }
    return isset(self::$file_cache) ? self::$file_cache : array();
  }

  static function build_file_cache($dir = '.') {
    # build file cache
    $files = glob($dir.'/*', GLOB_NOSORT);
    if($files && count($files)){
    	foreach($files as $path) {
	      $file = basename($path);
        //$file = preg_replace('/\s/', '_', basename($path));
	    	$is_dir = is_dir($path);
        //$dots = substr_count($file, '.');
        //if($dots > 1) $file = preg_replace('/\./', '_', $file, $dots - 1);
	    	//self::$bugme .= PHP_EOL . '<!-- ' . $path . ' -->';
	      self::$file_cache[$dir][] = array(
	        'path' => $path,
	        'file_name' => $file,
	        'is_folder' => $is_dir ? 1 : 0
	      );
	    }
    } else {
    	self::$file_cache[$dir] = array();
    }
  }
  
  static function list_files($dir, $regex, $folders_only = false, $sort = true) {
    $files = array();
    //if(!$regex && $folders_only) $regex = X3Config::$config["settings"]["hide_folders"] ? '\/\d+?\.[^\/]+$/' : '\/[^_][^\/]+$/';
    if(!$regex && $folders_only) $regex = '\/[^_][^\/]+$/';

    # $use_data
    if($folders_only && self::$use_data) {
    	foreach (self::$folders as $key => $val) {
    		if(preg_match('/' . preg_quote($dir, '/') . $regex, './content/' . $key) && (!isset($val['hidden']) || !$val['hidden'] || substr($key, -5) === 'index')){
    			$files[basename($key)] = './content/' . $key;
    		}
    	}

    } else {
    	foreach(self::file_cache($dir) as $file) {
	      # if file matches regex, continue
        if(isset($file['file_name']) && preg_match($regex, $file['file_name'])) {
	        # if $folders_only is true and the file is not a folder, skip it
	        if($folders_only && !$file['is_folder']) continue;
	        # otherwise, add file to results list
	        $files[$file['file_name']] = $file['path'];
	      }
	    }
    }

    # sort list in reverse-numeric order
    if($sort) natcasesort($files);
    return $files;
  }

  static function site_last_modified() {

    // cached value (just in case)
    if(self::$site_updated) return self::$site_updated;

  	# content touch
  	$content = filemtime(Config::$content_folder);

		# app updated
		$app = filemtime(Config::$app_folder.'/x3.inc.php');

		# touch file (optional)
    $touch = Config::$root_folder.'config/touch.txt';
    $touch_time = file_exists($touch) ? filemtime($touch) : 0;

    # global parent config files (../global.json and ../../global.json)
    $global_parent_config_time = 0;
    $global_parent_parent_config_time = 0;
    if(X3Config::$config["userx"]){
      $root_parent = dirname(dirname(__DIR__));
      $global_parent_config =  $root_parent . '/global.json';
      $global_parent_parent_config =  dirname($root_parent) . '/global.json';
      if(file_exists($global_parent_config)) $global_parent_config_time = @filemtime($global_parent_config);
      if(file_exists($global_parent_parent_config)) $global_parent_parent_config_time = @filemtime($global_parent_parent_config);
    }

    # updated
    //$updated = max($content, $app, $touch_time, $global_json_time);
    self::$site_updated = max($content, $app, $touch_time, $global_parent_config_time, $global_parent_parent_config_time);
    //return strval(date('c', self::$site_updated));
    return self::$site_updated;
  }

  static function translate_named_entities($string) {
    $mapping = array('&'=>'&#38;','&apos;'=>'&#39;', '&minus;'=>'&#45;', '&circ;'=>'&#94;', '&tilde;'=>'&#126;', '&Scaron;'=>'&#138;', '&lsaquo;'=>'&#139;', '&OElig;'=>'&#140;', '&lsquo;'=>'&#145;', '&rsquo;'=>'&#146;', '&ldquo;'=>'&#147;', '&rdquo;'=>'&#148;', '&bull;'=>'&#149;', '&ndash;'=>'&#150;', '&mdash;'=>'&#151;', '&tilde;'=>'&#152;', '&trade;'=>'&#153;', '&scaron;'=>'&#154;', '&rsaquo;'=>'&#155;', '&oelig;'=>'&#156;', '&Yuml;'=>'&#159;', '&yuml;'=>'&#255;', '&OElig;'=>'&#338;', '&oelig;'=>'&#339;', '&Scaron;'=>'&#352;', '&scaron;'=>'&#353;', '&Yuml;'=>'&#376;', '&fnof;'=>'&#402;', '&circ;'=>'&#710;', '&tilde;'=>'&#732;', '&Alpha;'=>'&#913;', '&Beta;'=>'&#914;', '&Gamma;'=>'&#915;', '&Delta;'=>'&#916;', '&Epsilon;'=>'&#917;', '&Zeta;'=>'&#918;', '&Eta;'=>'&#919;', '&Theta;'=>'&#920;', '&Iota;'=>'&#921;', '&Kappa;'=>'&#922;', '&Lambda;'=>'&#923;', '&Mu;'=>'&#924;', '&Nu;'=>'&#925;', '&Xi;'=>'&#926;', '&Omicron;'=>'&#927;', '&Pi;'=>'&#928;', '&Rho;'=>'&#929;', '&Sigma;'=>'&#931;', '&Tau;'=>'&#932;', '&Upsilon;'=>'&#933;', '&Phi;'=>'&#934;', '&Chi;'=>'&#935;', '&Psi;'=>'&#936;', '&Omega;'=>'&#937;', '&alpha;'=>'&#945;', '&beta;'=>'&#946;', '&gamma;'=>'&#947;', '&delta;'=>'&#948;', '&epsilon;'=>'&#949;', '&zeta;'=>'&#950;', '&eta;'=>'&#951;', '&theta;'=>'&#952;', '&iota;'=>'&#953;', '&kappa;'=>'&#954;', '&lambda;'=>'&#955;', '&mu;'=>'&#956;', '&nu;'=>'&#957;', '&xi;'=>'&#958;', '&omicron;'=>'&#959;', '&pi;'=>'&#960;', '&rho;'=>'&#961;', '&sigmaf;'=>'&#962;', '&sigma;'=>'&#963;', '&tau;'=>'&#964;', '&upsilon;'=>'&#965;', '&phi;'=>'&#966;', '&chi;'=>'&#967;', '&psi;'=>'&#968;', '&omega;'=>'&#969;', '&thetasym;'=>'&#977;', '&upsih;'=>'&#978;', '&piv;'=>'&#982;', '&ensp;'=>'&#8194;', '&emsp;'=>'&#8195;', '&thinsp;'=>'&#8201;', '&zwnj;'=>'&#8204;', '&zwj;'=>'&#8205;', '&lrm;'=>'&#8206;', '&rlm;'=>'&#8207;', '&ndash;'=>'&#8211;', '&mdash;'=>'&#8212;', '&lsquo;'=>'&#8216;', '&rsquo;'=>'&#8217;', '&sbquo;'=>'&#8218;', '&ldquo;'=>'&#8220;', '&rdquo;'=>'&#8221;', '&bdquo;'=>'&#8222;', '&dagger;'=>'&#8224;', '&Dagger;'=>'&#8225;', '&bull;'=>'&#8226;', '&hellip;'=>'&#8230;', '&permil;'=>'&#8240;', '&prime;'=>'&#8242;', '&Prime;'=>'&#8243;', '&lsaquo;'=>'&#8249;', '&rsaquo;'=>'&#8250;', '&oline;'=>'&#8254;', '&frasl;'=>'&#8260;', '&euro;'=>'&#8364;', '&image;'=>'&#8465;', '&weierp;'=>'&#8472;', '&real;'=>'&#8476;', '&trade;'=>'&#8482;', '&alefsym;'=>'&#8501;', '&larr;'=>'&#8592;', '&uarr;'=>'&#8593;', '&rarr;'=>'&#8594;', '&darr;'=>'&#8595;', '&harr;'=>'&#8596;', '&crarr;'=>'&#8629;', '&lArr;'=>'&#8656;', '&uArr;'=>'&#8657;', '&rArr;'=>'&#8658;', '&dArr;'=>'&#8659;', '&hArr;'=>'&#8660;', '&forall;'=>'&#8704;', '&part;'=>'&#8706;', '&exist;'=>'&#8707;', '&empty;'=>'&#8709;', '&nabla;'=>'&#8711;', '&isin;'=>'&#8712;', '&notin;'=>'&#8713;', '&ni;'=>'&#8715;', '&prod;'=>'&#8719;', '&sum;'=>'&#8721;', '&minus;'=>'&#8722;', '&lowast;'=>'&#8727;', '&radic;'=>'&#8730;', '&prop;'=>'&#8733;', '&infin;'=>'&#8734;', '&ang;'=>'&#8736;', '&and;'=>'&#8743;', '&or;'=>'&#8744;', '&cap;'=>'&#8745;', '&cup;'=>'&#8746;', '&int;'=>'&#8747;', '&there4;'=>'&#8756;', '&sim;'=>'&#8764;', '&cong;'=>'&#8773;', '&asymp;'=>'&#8776;', '&ne;'=>'&#8800;', '&equiv;'=>'&#8801;', '&le;'=>'&#8804;', '&ge;'=>'&#8805;', '&sub;'=>'&#8834;', '&sup;'=>'&#8835;', '&nsub;'=>'&#8836;', '&sube;'=>'&#8838;', '&supe;'=>'&#8839;', '&oplus;'=>'&#8853;', '&otimes;'=>'&#8855;', '&perp;'=>'&#8869;', '&sdot;'=>'&#8901;', '&lceil;'=>'&#8968;', '&rceil;'=>'&#8969;', '&lfloor;'=>'&#8970;', '&rfloor;'=>'&#8971;', '&lang;'=>'&#9001;', '&rang;'=>'&#9002;', '&loz;'=>'&#9674;', '&spades;'=>'&#9824;', '&clubs;'=>'&#9827;', '&hearts;'=>'&#9829;', '&diams;'=>'&#9830;');
    foreach (get_html_translation_table(HTML_ENTITIES, ENT_QUOTES) as $char => $entity){
      $mapping[$entity] = '&#' . ord($char) . ';';
    }
    return str_replace(array_keys($mapping), $mapping, $string);
  }

  // javascript html attribute friendly
  public static function attribute_friendly($str){
    if(empty($str)) return '';
    $name = function_exists('mb_strtolower') ? mb_strtolower($str, mb_detect_encoding($str)) : strtolower($str);
    // remove 1.number and extension.jpg and lowercase
    $name = preg_replace(array('/\.[\w\d]+?$/', '/^\d+?\./'), '', $name);
    return trim(preg_replace('/\-+/', '-', str_replace(str_split(' .,()[]/"\\\'!?#`~@_$%^&*+=:;<>{}'), '-', $name)), '-');
    // preg_split('//u', ' .,()[]/"“’\\\'!?#`~@_$%^&*+=:;<>{}', -1, PREG_SPLIT_NO_EMPTY)
  }

}

?>