<?php

# X3
Class X3 {

  static $version = '3.27.6';
  static $version_date = 1551789126985;
  static $server_protocol = 'http://';

  var $route;
  var $is_protected = false;

  function handle_redirects() {

  	// get config and request
  	if(!isset($_GET["noredirect"])){
	  	$request = $this::$server_protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	  	// proceed only if not empty and not already enforce URL
	  	if(!empty(X3Config::$config["back"]["enforce_url"]) && stripos($request, X3Config::$config["back"]["enforce_url"]) !== 0){

	  		// trim it properly
	  		$enforce_url = trim(X3Config::$config["back"]["enforce_url"], ' /:');

	  		// continue if not empty
	  		if(!empty($enforce_url)){

	  			// SSL/https
	  			if((strtolower($enforce_url) === 'ssl' || strtolower($enforce_url) === 'https') && $this::$server_protocol !== 'https://'){
	  				$redirect_path = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	  			// www
	  			} else if(strtolower($enforce_url) === 'www' && stripos($_SERVER['HTTP_HOST'], 'www.') !== 0){
	  				$redirect_path = $this::$server_protocol . 'www.' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	  			// match
	  			} else if(stripos($request, $enforce_url) !== 0){
		  			$root_path = str_replace("\\", '', dirname($_SERVER['PHP_SELF']));
		  			$redirect_path = $enforce_url . ($root_path === '/' ? $_SERVER['REQUEST_URI'] : substr($_SERVER['REQUEST_URI'], strlen($root_path)));
		  		}

		  		// process redirect
		  		if(isset($redirect_path)){
		  			if(!preg_match('/\/$/', $redirect_path) && !preg_match('/[\.\?\&][^\/]+$/', $redirect_path)) $redirect_path .= '/';
		  			header('HTTP/1.1 301 Moved Permanently');
	      		header('Location:'.$redirect_path);
	      		return true;
		  		}
	  		}
	  	}
	  }

    # add trailing slash if required
    if(!preg_match('/\/$/', $_SERVER['REQUEST_URI']) && !preg_match('/[\.\?\&][^\/]+$/', $_SERVER['REQUEST_URI'])) {
      header('HTTP/1.1 301 Moved Permanently');
      header('Location:'.$_SERVER['REQUEST_URI'].'/');
      return true;
    }
    return false;
  }

  function php_fixes() {
    $tz = ini_get('date.timezone');
    if(empty($tz)) date_default_timezone_set('Europe/Zurich');
  }

  // X3 cache-control
  function cache_control($expires, $template_file){

    // never cache passwords and site.json
  	if($this->is_protected || basename($template_file) === 'site.json') {
  		header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0, s-maxage=0');
  		header('Pragma: no-cache');
  		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

  	// standard pages
  	} else {

  		// set standard cache-control headers
  		$cache_control = 'Cache-Control: public, max-age=' . $expires;

  		// s-maxage?
    	$x3_panel = X3Config::$config["back"]["panel"];
  		$s_maxage = $x3_panel["cloudflare_enabled"] && !empty($x3_panel["cloudflare_email"]) && !empty($x3_panel["cloudflare_key"]) ? true : false;

  		// add s-maxage
  		if($s_maxage) $cache_control .= ', s-maxage=315360000';

  		// write cache-control
  		header($cache_control);

  		// expires
  		if($expires || $s_maxage){
  			$expires_time = gmdate('D, d M Y H:i:s', time() + (empty($expires) ? 10 : $expires));
  		} else {
  			$expires_time = gmdate('D, d M Y H:i:s');
  		}
    	header('Expires: ' . $expires_time . ' GMT');
  	}
  }

  function set_content_type($template_file) {

    # split by file extension
    preg_match('/\.([\w\d]+?)$/', $template_file, $split_path);

    # Set headers
    switch ($split_path[1]) {
    	case 'html':
        header("Content-type: text/html; charset=utf-8");
        $this->cache_control(0, $template_file);
        break;
    	case 'json':
        header('Content-type: application/json; charset=utf-8');
        $this->cache_control(315360000, $template_file);
        break;
      case 'atom':
        # header("Content-type: application/atom+xml; charset=utf-8");
        header("Content-type: application/xml; charset=utf-8");
        $this->cache_control(3600, $template_file);
        break;
      case 'xml':
        header("Content-type: text/xml; charset=utf-8");
        $this->cache_control(3600, $template_file);
        break;
      default:
        # set html/utf-8 charset header
        header("Content-type: text/html; charset=utf-8");
    }
  }

  function etag_expired($cache) {
    header('Etag: "'.$cache->hash.'"');
    # Safari incorrectly caches 304s as empty pages, so don't serve it 304s
    if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) return true;
    # Check for a local cache
    if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) == '"'.$cache->hash.'"') {
      # local cache is still fresh, so return 304
      header("HTTP/1.0 304 Not Modified");
      header('Content-Length: 0');
      return false;
    } else {
      return true;
    }
  }

  function render($file_path, $template_file) {
  	//global $time_pre;
    $cache = new Cache($file_path, $template_file, $this->is_protected);
    # set any custom headers
    $this->set_content_type($template_file);
    header('Generator: X' . X3::$version . ' / www.photo.gallery');

    // no-index, nofollow (none) for image landing pages?
    if(X3Config::$config["settings"]["image_noindex"] && basename($template_file) === 'file.html') header('X-Robots-Tag: noindex');

    # if etag is still fresh, return 304 and don't render anything
    if(!$this->etag_expired($cache)) return;
    
    # if cache has expired
    if($cache->expired()) {
      # render page & create new cache
      $cache->create($this->route, $file_path, true, true);
    } else {
      # render the existing cache
      echo $cache->render();
    }
  }

	// X3 Protect
	function protect($template_file){

		# strictly for sample content
		if($this->route === 'examples/features/password') {
			$this->setAuth(array('username' => 'guest', 'password' => 'guest'), Page::template_type($template_file));
			$this->is_protected = 'recursive';
			return;
		}

    // protect.json
    if(file_exists('./config/protect.json')){
      $protect = @file_get_contents('./config/protect.json');

    // protect.php (legacy)
    } else if(file_exists('./config/protect.php')){
      require_once './config/protect.php';
    }

		# get object
		global $protect_ob;
    $protect_ob = isset($protect) && !empty($protect) ? @json_decode(trim($protect), true) : array();

    # Only continue if access is not empty
    if(empty($protect_ob) || !isset($protect_ob["access"]) || empty($protect_ob["access"])) return;

    # get access object
    $x3_access = $protect_ob["access"];

    // Collapse grouped access links
    foreach ($x3_access as $key => $value) {
    	if(substr_count($key, ',') > 0){
    		$keys = explode(",", $key);
    		foreach ($keys as $url) {
    			if(!array_key_exists($url, $x3_access)) $x3_access[$url] = $value;
    		}
    		unset($x3_access[$key]);
    	}
    }

    // Sort by amount of slashes (folder deep on top)
    uksort($x3_access, function($a, $b){
    	return (substr_count($a,'/') < substr_count($b,'/')) ? 1 : -1;
		});

    if(!empty($x3_access)){
    	$broke = false;
    	$route = $this->route;

    	// Check equal links first
	  	foreach ($x3_access as $key => $value) {
	  		$keys = explode(',', $key);
	  		foreach ($keys as $url) {
          $item = str_replace('.', '_', rtrim($url, '/*'));
		  		if($item == $route){
		  			$this->is_protected = 'recursive';
		  			$this->setAuth($value, Page::template_type($template_file));
		  			$broke = true;
		  			break 2;
		  		}
	  		}
			}

			// Check recursive
			if(!$broke) {
				foreach ($x3_access as $key => $value) {
		  		$keys = explode(',', $key);
		  		foreach ($keys as $url) {
            $item = str_replace('.', '_', rtrim($url, '/*'));
			  		if(substr($route, 0, strlen($item)) === $item){
			  			$this->is_protected = 'recursive';
			  			$this->setAuth($value, Page::template_type($template_file));
			  			break 2;
			  		}
		  		}
				}
			}
    }
	}

  // create page
  function create_page($file_path) {

    # return a 404 if a matching folder doesn't exist
    if(!file_exists($file_path)) throw new Exception('404');

    # register global for the path to the page which is currently being viewed
    global $current_page_file_path;
    $current_page_file_path = $file_path;

    # register global for the template for the page which is currently being viewed
    global $current_page_template_file;

    # Set template name: file or page, or 404 if in array.
    //$template_name = is_file($file_path) ? 'file' : (in_array($file_path, array('./content/custom','./content/custom/favicon','./content/custom/logo','./content/custom/audio')) ? '404' : 'page');
    $template_name = is_file($file_path) ? 'file' : ($file_path !== './content/custom/404' && (strpos($file_path, './content/custom/') === 0 || $file_path === './content/custom') ? '404' : 'page');

  	# Set current template file
    $current_page_template_file = Page::template_file($template_name);

    # error out if template file doesn't exist (or glob returns an error)
    if(empty($template_name) || $template_name == '404') throw new Exception('404');

    # Check auth protect
    $this->protect($current_page_template_file);

  	# render page
  	$this->render($file_path, $current_page_template_file);
  }

  // X3 set auth
  function setAuth($value, $template){
  	include "./app/auth.inc.php";
  	$username = empty($value["username"]) ? null : $value["username"];
		$password = empty($value["password"]) ? null : $value["password"];
		$users = empty($value["users"]) ? null : $value["users"];
		if(!empty($password) || !empty($users)) new BasicAuth($username, $password, $users, $template);
  }

  // X3 Service routes
  function x3Services(){
  	# Global X3 routes
		global $x3_service;
		global $x3_service_templates;
		$x3_service = array("services/site", "services/menu", "services/video");
		$x3_service_templates = array("site.json", "menu.html", "video.html");

		// Sitemap?
		if(X3Config::$config["settings"]["sitemap"]) {
			array_unshift($x3_service, "sitemap");
			array_unshift($x3_service_templates, "sitemap.xml");
		}

		// Feed?
		if(X3Config::$config["settings"]["feed"]) {
			array_unshift($x3_service, "feed");
			array_unshift($x3_service_templates, "feed.atom");
		}
  }

  // X3 Find File
  function x3FindFile($file_path, $name){
    // check name, then text space and dot
    foreach (array($name, str_replace('_',' ',$name), str_replace('_','.',$name)) as $name) {
      $regex = '/' . preg_quote($name) . '\.(jpg|jpeg|png|gif)/i';
      $files = array_keys(Helpers::list_files($file_path, $regex, false, false));
      if(count($files)) break;
    }
  	return end($files);
  }

  function __construct($get) {
  	# Set protocol
  	$this::$server_protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

  	# Create X3 Service routes
  	$this->x3Services();
    # sometimes when PHP release a new version, they do silly things - this function is here to fix them
    $this->php_fixes();
    # it's easier to handle some redirection through php rather than relying on a more complex .htaccess file to do all the work
    if($this->handle_redirects()) return;
    # strip any leading or trailing slashes from the passed url
    $key = key($get);
    # if the key isn't a URL path, then ignore it
    if (!preg_match('/\//', $key)) $key = false;
    $key = preg_replace(array('/\/$/', '/^\//'), '', $key);
    # store file path for this current page
    $this->route = isset($key) ? $key : 'index';
    # strip any trailing extensions from the url
    $this->route = preg_replace('/[\.][\w\d]+?$/', '', $this->route);
    # $this->route = preg_replace('/[\.|\_][\w\d]+?$/', '', $this->route); // 0.8

    # Get X3 Route services
    global $x3_service;
		global $x3_service_templates;

		# Double underscore always 404
		if(strpos(basename($this->route), '__') === 0) {
			$this->not_found();
			return;
		}

    // load folders.json
    Helpers::get_folders();

		# X3 Service Route
    if(in_array($this->route, $x3_service)) {

    	$file_path = "./" . $this->route;
	    global $current_page_file_path;
	    $current_page_file_path = $file_path;
	    global $current_page_template_file;
	    $current_page_template_file = Config::$templates_folder. '/' . $x3_service_templates[array_search($this->route, $x3_service)];
	    $this->protect($current_page_template_file);
    	$this->render($file_path, $current_page_template_file);

    # X3 Page
    } else {

    	$file_path = Helpers::url_to_file_path($this->route, true);

    	# X3 Check if file_path is file
	    if(empty($file_path) && basename($this->route) !== 'preview') {

	    	// If index
	    	$dirname = dirname($this->route);
	    	$file_route = ($dirname === '.' || empty($dirname)) ? '' : $dirname;

	    	// make sure parent is folder
	    	$file_path = Helpers::url_to_file_path($file_route, true);

	    	// If is folder path, look for file
	    	if(!empty($file_path)) {

	    		# file name without extension
	    		$name = basename($key);

	    		// Search file
	    		$file = $this->x3FindFile($file_path, $name);

	    		// Make file_path if $file is not empty
	    		$file_path = empty($file) ? null : $file_path.'/'.$file;
	    	}
	    }

	    # Check if path is empty, return 404
	    if(empty($file_path)) {
	    	$this->not_found();

	    # Try create page
	    } else {
		    try {
		      # create and render the current page
		      $this->create_page($file_path);
		    } catch(Exception $e) {
		      if($e->getMessage() == "404") {
		        $this->not_found();
		      } else {
		        echo '<h3>'.$e->getMessage().'</h3>';
		      }
		    }
	    }

    }
  }

  # Page not found
  function not_found(){
  	# return 404 headers
    header('HTTP/1.0 404 Not Found');
    if(file_exists(Config::$content_folder.'/custom/404')) {

      // check if file exits for mistaken pronto .json requests
      $split = explode('.json', $_SERVER['REQUEST_URI']);
      if(count($split) > 1 && file_exists($_SERVER["DOCUMENT_ROOT"] . $split[0])) header('file_exists: true');

      $this->route = 'custom/404';
      $this->create_page(Config::$content_folder.'/custom/404');
    } else {
    	$page = isset($this->route) ? $this->route : '';
    	echo "<h1>Not Found</h1><p>The requested page " . $page . " was not found.</p>";
    }
  }
}
?>
