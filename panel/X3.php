<?php

// X3 class
class X3 {

	// IPTC manage

	// get iptc data
	public static function get_iptc_data($iptc){
  	$data = self::iptc_data($iptc, '005', 'title')
					. self::iptc_data($iptc, '120', 'description');

		// only add X3 IPTC if "use iptc"
		if(X3Config::$config['back']['use_iptc']) {
			$data .= self::iptc_data($iptc, '217', 'link')
						. self::iptc_data($iptc, '220', 'params');

			// link target
			if(isset($iptc['2#218'][0]) && in_array($iptc['2#218'][0], array('auto','_self','_blank','popup','x3_popup'))) $data .= self::get_iptc_data_attribute('link-target', $iptc['2#218'][0]);

			// hidden
			if(isset($iptc["2#219"][0]) && $iptc["2#219"][0] == '1') $data .= self::get_iptc_data_attribute('hidden', '1');

			// index/custom
			if(isset($iptc["2#216"][0]) && is_numeric($iptc["2#216"][0])) {
				$data .= self::get_iptc_data_attribute('custom', $iptc["2#216"][0]);
				$data .= self::get_iptc_data_attribute('index', $iptc["2#216"][0]);
			}
		}

		return $data;
  }

  // utf8 validate
  private static function utf8_validate($string){
		return htmlspecialchars(@mb_detect_encoding($string, 'UTF-8', true) ? $string : @utf8_encode($string), ENT_QUOTES);
  }

  // iptc data string
  private static function iptc_data($iptc, $id, $name){
  	if(!isset($iptc['2#' . $id][0]) || empty($iptc['2#' . $id][0])) return '';
  	return self::get_iptc_data_attribute($name, self::utf8_validate($iptc['2#' . $id][0]));
  }

  //
  private static function get_iptc_data_attribute($name, $val){
  	return ' data-' . $name . '="' . $val . '"';
  }


	// FOLDERS.JSON manage

	// X3 json decode POST
	public static function json_decode($str){
		$parsed = get_magic_quotes_gpc() ? stripslashes($str) : $str;
		return json_decode($parsed, TRUE);
	}

	//static $folders_path = '../../content/folders.json';
	private static function folders_path(){
		return dirname(__DIR__) . '/content/folders.json';
	}

	private static function content_dir(){
		return file_exists('../content') ? '../content' : dirname(__DIR__) . '/content';
	}

	// get content path (path relative to /content/)
	public static function get_content_path($val){
		$search = '/content/';
		if(strpos($val, ('.' . $search)) !== false) {
			$search = '.' . $search;
		} else if(!$val || strpos($val, $search) === false) return;
		$arr = explode($search, $val);
		array_shift($arr);
		return implode($search, $arr);
	}

	// remove folders key
	public static function remove_folders_key($dirs){
		if(empty($dirs)) return;
		if(!is_array($dirs)) $dirs = array($dirs);
		$folders = self::get_folders();
		if(empty($folders)) return;
		$changes = 0;
		for ($i=0; $i < count($dirs); $i++) {
			$dir = self::get_content_path($dirs[$i]);
			if(!$dir) continue;

			// check children
			foreach ($folders as $key => $value) {
				if(strpos($key, $dir) === 0){
					$changes ++;
					unset($folders[$key]);
				}
			}
		}
		if($changes) self::write_folders($folders);
  }

	// update folders key
	public static function update_folders_key($old, $new, $copy = false){
		if(empty($old) || empty($new)) return;
		if(!is_array($old)) $old = array($old);
		if(!is_array($new)) $new = array($new);
		$folders = self::get_folders();
		if(empty($folders)) return;
		$changes = 0;
		for ($i=0; $i < count($old); $i++) {
			$old_dir = self::get_content_path($old[$i]);
			$new_dir = self::get_content_path($new[$i]);

			// continue if dir not set
			if(!$old_dir || !$new_dir) continue;

			// check children
			foreach ($folders as $key => $value) {
				if(strpos($key, $old_dir) === 0){
					$changes ++;
					$sub = preg_replace(('/' . preg_quote($old_dir, '/') . '/'), $new_dir, $key, 1);
					$folders[$sub] = $value;
					if(!$copy) unset($folders[$key]);
				}
			}
		}
		if($changes) self::write_folders($folders);
  }

  // write folders.json
	public static function write_folders($folders){
		$json = phpversion() < 5.4 ? json_encode($folders, JSON_FORCE_OBJECT) : json_encode($folders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT);
		return @file_put_contents(self::folders_path(), $json);
  }

  //
  private static $folders;

	// get folders.json
	public static function get_folders($decode = true){
		if($decode && isset(self::$folders)) return self::$folders;
		$folders = $decode ? array() : '{}';
		if(file_exists(self::folders_path())){
			$folders_data = file_get_contents(self::folders_path());
			if(!empty($folders_data)) {
				$folders = $decode ? json_decode($folders_data, TRUE) : $folders_data;
			}
		}
		if($decode && empty($folders)) $folders = self::get_dirs(self::content_dir());
		if($decode) self::$folders = $folders;
		return $folders;
  }

  // get dirs
  public static function get_dirs($dir){
  	$basename = basename($dir);
  	if($basename[0] === '_') return;
  	$arr = array();
  	$dirs = glob($dir . '/*', GLOB_ONLYDIR|GLOB_NOSORT);
  	if(empty($dirs)) return $arr;
		foreach($dirs as $dir){
			$content_path = self::get_content_path($dir);
			if($content_path === 'custom' || !$content_path) continue;
			$arr[$content_path]['url'] = preg_replace('/\d+?\./', '', $content_path);
			foreach (self::get_dirs($dir) as $key => $value) {
				$arr[$key] = $value;
			}
		}
		return $arr;
  }

  // refresh folders
  public static function refresh_folders(){
  	$dirs = self::get_dirs(self::content_dir());

		// merge
		if(file_exists(self::folders_path())){
			self::merge_folders($dirs, true);

		// write new folders.json
		} else {
			self::write_folders($dirs);
		}
  }

  //
  public static function merge_folders($data, $intersect = false){
  	$folders = self::get_folders();
  	if($intersect) $folders = array_intersect_key($folders, $data);
  	$merged = array_replace_recursive($folders, $data);
  	if(!$intersect) foreach ($merged as $key => $val) {
  		$arr = array('hidden', 'index');
  		foreach ($arr as $prop) {
  			if(isset($val[$prop]) && !$val[$prop]) unset($merged[$key][$prop]);
  		}
  	}
  	return self::write_folders($merged);
  }


  /* PANEL MENU */

  // data array
	static $data = array();

	// add to data
	private static function add_data($dir){
		if(strpos($dir . '/', './content/custom/') === false) {
			$content_path = self::get_content_path($dir);
			self::$data[$content_path]['url'] = preg_replace('/\d+?\./', '', $content_path);
		}
	}

	// make dir tree
	public static function make_dir_tree($directory){

		$menu = '';
		$dirs = glob($directory, GLOB_ONLYDIR|GLOB_NOSORT);
		if(!empty($dirs)){
			natcasesort($dirs);
			$sort = 0;
			$dir_object = array();
			$custom_sort = false;
			foreach($dirs as $dir){
				$content_path = self::get_content_path($dir);
				$dir_object[$dir] = array();
				$dir_object[$dir]['content_path'] = $content_path;
				$dir_object[$dir]['sort'] = $content_path === 'custom' ? 0 : $sort++;
				$custom = isset(self::$folders[$content_path]['index']) ? self::$folders[$content_path]['index'] : 0;
				$dir_object[$dir]['custom'] = $custom;
				if($custom) $custom_sort = true;
			}
			if($custom_sort) uasort($dir_object, function($a, $b){
		    return $a['custom'] > $b['custom'];
	    });

			// menu html
	    $menu .= '<ul>';
			foreach($dir_object as $dir => $val){
				$content_path = $val['content_path'];
				$menu_id = '_' . trim(preg_replace('/\_+/', '_', str_replace(str_split(' .,()[]/"“’\\\'!?#`~@-$%^&*+=:;<>{}'), '_', $content_path)), '_');
				$dir_escaped = htmlspecialchars($dir);
				$name = basename($dir_escaped);
				$submenu = $name[0] === '_' ? '' : self::make_dir_tree($dir . '/*');
				$menu .= '<li data-sort="' . $val['sort'] . '" data-custom="' . $val['custom'] . '" data-content-path="' . htmlspecialchars($content_path) . '" data-dir="' . $dir_escaped . '" data-name="' . $name . '" id="' . $menu_id . '"><a href="#" data-href="' . $dir_escaped . '" rel="nofollow">' . $name . '</a>' . $submenu . '</li>';
				self::add_data($dir);
			}
			$menu .= '</ul>';
		}
		return $menu;
	}
}


?>