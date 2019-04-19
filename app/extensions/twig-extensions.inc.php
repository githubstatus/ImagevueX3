<?php
require_once Config::$app_folder.'/parsers/Twig/ExtensionInterface.php';
require_once Config::$app_folder.'/parsers/Twig/Extension.php';

class X3_Twig_Extension extends Twig_Extension {

  public function getName() {
    return 'X3';
  }

  public function getFilters() {
    # custom twig filters
    return array(
      'absolute' => new Twig_Filter_Method($this, 'absolute'),
      'context' => new Twig_Filter_Method($this, 'context'),
      'truncate' => new Twig_Filter_Method($this, 'truncate')
    );
  }

  public function getFunctions() {
    # custom Twig functions
    return array(
      //'search' => new Twig_Function_Method($this, 'search'),
      'sortby' => new Twig_Function_Method($this, 'sortby'),
      'debug' => new Twig_Function_Method($this, 'var_dumper'),
      'pebug' => new Twig_Function_Method($this, 'var_dumper_pre'),
      'get' => new Twig_Filter_Method($this, 'get'),
      'slice' => new Twig_Filter_Method($this, 'slice'),
      'resize_path' => new Twig_Filter_Method($this, 'resize_path'),
      'get_adjacent_siblings' => new Twig_Filter_Method($this, 'get_adjacent_siblings')
    );
  }

  // get adjacent siblings dir
  function get_adjacent_siblings($dir){

  	// result
  	$result = array(false, false);

  	// sort config
  	$parent = dirname($dir);
  	$json = array();
  	if($parent !== './content'){
  		$file = $parent . '/page.json';
  		$json_content = file_exists($file) ? @file_get_contents($file) : false;
  		if(!empty($json_content)) $json = json_decode($json_content, TRUE);
  	}
  	$config = array_replace_recursive(X3Config::$config, $json);
  	$sortby = $config['folders']['sortby'];

  	// siblings dirs
  	$dirs = Helpers::list_files($parent, false, true);
  	if(empty($dirs)) return false;

  	// dir object
  	$dir_object = array();
  	$keys = array();
  	$default_index = -9999;
  	foreach ($dirs as $name => $path) {
  		$dir_object[$path] = array();
  		$dir_object[$path]['name'] = $name;
  		$dir_object[$path]['slug'] = preg_replace('/\d+?\./', '', $name);
  		if($sortby === 'custom'){
	  		$content_path = str_replace('./content/', '', $path);
	  		$dir_object[$path]['index'] = isset(Helpers::$folders[$content_path]['index']) ? Helpers::$folders[$content_path]['index'] : $default_index++;

      // date
	  	} else if($sortby === 'date'){

        $page_date = false;
        $page_json_file = $path . '/page.json';
        $page_json_content = file_exists($page_json_file) ? @file_get_contents($page_json_file) : false;
        if(!empty($page_json_content)) {
          $page_json = @json_decode($page_json_content, TRUE);
          if(!empty($page_json) && isset($page_json['date'])) $page_date = @strtotime($page_json['date']);
        }
        $dir_object[$path]['date'] = $page_date ? $page_date : filemtime($path);
      }
  	}

  	// custom sort
  	if($sortby === 'custom'){
  		uasort($dir_object, function($a, $b){
		    return $a['index'] > $b['index'];
	    });
  	} else if($sortby === 'title'){
  		uasort($dir_object, function($a, $b){
		    return strnatcasecmp($a['slug'], $b['slug']);
	    });
  	} else if($sortby === 'date'){
  		uasort($dir_object, function($a, $b){
		    return $a['date'] > $b['date'];
	    });
  	}

  	// reverse sort
    if($config['folders']['sort'] === 'desc') $dir_object = array_reverse($dir_object);

  	//$dirs = array_flip($dirs);
  	$keys = array_keys($dir_object);
  	$index = array_search($dir, $keys);
  	if($index === false || count($keys) < 2) return false;

  	// sibling previous
  	if($index > 0) {
  		$prev_dir = $keys[$index - 1];
  		$dir_slug = $dir_object[$prev_dir]['slug'];
      $slug = str_replace(' ', '_', $dir_slug);
      $label = ucwords(str_replace(array('_', '-'), ' ', $dir_slug));
  		$result[0] = array('slug' => $slug, 'label' => $label);
  	}
  	// sibling next
  	if($index < (count($keys) - 1)){
  		$next_dir = $keys[$index + 1];
  		$dir_slug = $dir_object[$next_dir]['slug'];
      $slug = str_replace(' ', '_', $dir_slug);
      $label = ucwords(str_replace(array('_', '-'), ' ', $dir_slug));
  		$result[1] = array('slug' => $slug, 'label' => $label);
  	}
    
  	return $result;
  }

  #
  #   search
  #

  /*public function search($search, $limit = 20) {
    if(strlen($search) > 2) {
      $result = Cache::get_full_cache();

      if (preg_match('/^\s*$/', $search)) return array();
      $search = preg_replace(array('/\//', '/\s+/'), array('\/', '.+?'), $search);
    // $search = preg_replace(array('/o/i', '/a/i'), array('(o|ø|ö)', '(a|æ|å|ä)'), $search);
      $json = json_decode($result, true);

      $results = array();
      foreach ($json as $page) {
        foreach ($page as $key => $value) {
          if (preg_match('/\/404\//', $page['url'])) continue;
          if ($key == 'file_path' || $key == 'url') continue;
          $clean_value = (is_string($value)) ? strip_tags($value) : '';
          if (preg_match('/.{0,90}'.$search.'.{0,90}/i', $clean_value, $matches)) {
            if (isset($matches[0])) {
              $page['search_match'] = '... '.preg_replace('/('.$search.')/ui', '<mark>$1</mark>', $matches[0]).'...';
              $results[] = $page;
              if ($limit && count($results) >= $limit) return $results;
              break;
            }
          }
        }
      }
      return $results;
    }
  }*/

  #
  #   dump out our var for easy debugging
  #
  public function var_dumper($input) {
    var_dump( $input );
  }

  #
  #   dump out our var for easy debugging ++ Now with Extra Pre's
  #
  public function var_dumper_pre($input) {
    echo "<pre>";
    print_r( $input );
    echo "</pre>";
  }

  #
  #   manually change page context
  #
  function get($url, $current_url = '') {
    # strip leading & trailing slashes from $url
    $url = preg_replace(array('/^\//', '/\/$/'), '', $url);
    # if the current url is passed, then we use it to build up a relative context
    $url = preg_replace('/^\.\/\?/', '', $current_url).$url;
    # strip leading '../'s from the url if any exists
    $url = preg_replace('/^((\.+)*\/)*/', '', $url);
    # turn route into file path
    $file_path = Helpers::url_to_file_path($url);
    # check for children of the index page
    if (!$file_path) return $file_path = Helpers::url_to_file_path('index/'.$url);
    # create & return the new page object
    return AssetFactory::get($file_path);
  }

  #
  # shortcut to generate the image resize path from a full image path
  #
  //function resize_path($img_path, $max_width = '100', $max_height = '100', $ratio = '1:1', $quality = '100') {
  function resize_path($img_path, $max_width, $max_height, $ratio, $quality) {

    $root_path = preg_replace('/content\/.*/', '', $img_path);
    $clean_path = preg_replace('/^(\.+\/)*content/', '', $img_path);

    /*if(!file_exists(Config::$root_folder.'.htaccess')) {
    	$params = $root_path.'app/parsers/slir/index.php?';
    	if(isset($max_width)) $params.= 'w='.$max_width;
    	if(isset($max_height)) $params.= '&h='.$max_height;
    	if(isset($ratio)) $params.= '&c='.$ratio;
    	if(isset($quality)) $params.= '&q='.$quality;
    	$params.= '&i='.$clean_path;
    	return $params;

      //return $root_path.'app/parsers/slir/index.php?w='.$max_width.'&h='.$max_height.'&c='.$ratio.'&q='.$quality.'&i='.$clean_path;
    } else {*/
    	$params = $root_path.'render/';
    	if(isset($max_width)) $params.= 'w'.$max_width;
    	if(isset($max_height)) $params.= '-h'.$max_height;
    	if(isset($ratio)) $params.= '-c'.$ratio;
    	if(isset($quality)) $params.= '-q'.$quality;
    	$params.= $clean_path;
    	return $params;

      //return $root_path.'render/w'.$max_width.'-h'.$max_height.'-c'.$ratio.'-q'.$quality.$clean_path;
    //}
  }

  #
  # allow offsetting and limiting arrays
  #
  function slice($array, $start, $end) {
    return array_slice($array, $start, $end);
  }

  // X3 sort by
  function sortby($object, $value, $reverse = false) {
    $sorted = array();
    $default_index = -9999;

    if(is_array($object)) {

    	// stop immediately if array is empty
    	if(empty($object)) return $sorted;

    	# expand sub variables if required
      foreach($object as $key => $val) {
        if(is_string($val)) {
        	//$sorted[] =& AssetFactory::get($val);
        	$sort_el =& AssetFactory::get($val);
        	// don't include hidden
        	//if($sort_el && (!isset($sort_el['hidden']) || empty($sort_el['hidden']))) $sorted[] =& $sort_el;
        	if($sort_el && (!isset($sort_el['hidden']) || empty($sort_el['hidden']))) {
        		$sorted[$val] =& $sort_el;
        		if(!$sorted[$val]['index']) $sorted[$val]['index'] = $default_index++;
        	}
        }
      }
    }

    // name, title, date, shuffle, custom

    // stop processing if sort method is shuffle
    if($value === 'shuffle') return $sorted;

    // date sort
    if($value === 'date'){
	    uasort($sorted, function($a, $b){
		  	return $a['date'] > $b['date'];
	    });

	  // title sort
    } else if($value === 'title'){
	    uasort($sorted, function($a, $b){
		    return strnatcasecmp($a['sort_title'], $b['sort_title']);
	    });

	  // custom sort (index)
    } else if($value === 'custom'){
	    uasort($sorted, function($a, $b){
		    return $a['index'] > $b['index'];
	    });
    }

    // reverse sort
    if($reverse) $sorted = array_reverse($sorted);

    // return
    return $sorted;
  }

  #
  #   transforms relative path to absolute
  #
  function absolute($relative_path) {
    $server_name = (($_SERVER['HTTPS'] ? 'https://' : 'http://')).$_SERVER['HTTP_HOST'];
    $relative_path = preg_replace(array('/^\/content/', '/^(\.+\/)*/'), '', $relative_path);
    return $server_name.str_replace('/index.php', $relative_path, $_SERVER['SCRIPT_NAME']);
  }

  function truncate($value, $length = 30, $preserve = false, $separator = '...') {
    if (strlen($value) > $length) {
      if ($preserve) {
        if (false !== ($breakpoint = strpos($value, ' ', $length))) {
          $length = $breakpoint;
        }
      }
      return substr($value, 0, $length) . $separator;
    }
    return $value;
  }

}

?>
