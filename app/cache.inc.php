<?php

Class Cache {

  var $hash;
  var $path_hash;
  var $cachefile;
  var $cache_prefix = 'c-';
  var $is_protected = false;

  function __construct($file_path, $template_file, $is_protected = false) {

		// prepare path for path_hash : /x3 + /content/4.contact + :page.html
		$mypath = rtrim(str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])), '/') . trim($file_path, '.');

  	# is protected
  	$this->is_protected = $is_protected;

    # generate an md5 hash from the file_path
    $this->path_hash = $this->generate_hash($mypath.':'.basename($template_file));

    # content touch
    $content = 'content:' . filemtime(Config::$content_folder);

    # app updated
    $app = 'app:' . filemtime(Config::$app_folder.'/x3.inc.php');

    # touch file (optional)
    $touch = Config::$root_folder.'config/touch.txt';
    $touch_time = file_exists($touch) ? 'touch:' . filemtime($touch) : '';

    # global parent configs (optional)
    $global_parent_config_time = '';
    $global_parent_parent_config_time = '';
    if(X3Config::$config["userx"]){
      $root_parent = dirname(dirname(__DIR__));
      $global_parent_config =  $root_parent . '/global.json';
      $global_parent_parent_config =  dirname($root_parent) . '/global.json';
      if(file_exists($global_parent_config)) $global_parent_config_time = 'global_parent_config:' . filemtime($global_parent_config);
      if(file_exists($global_parent_parent_config)) $global_parent_parent_config_time = 'global_parent_parent_config:' . filemtime($global_parent_parent_config);
    }

    # unique updated hash
    $update_hash = $this->generate_hash($content.$app.$touch_time.$global_parent_config_time.$global_parent_parent_config_time);

    # store the hash
    $this->hash = $this->cache_prefix.$this->path_hash.'-'.$update_hash;

    # cachefile path
    $this->cachefile = Config::$cache_folder.'/pages/'.$this->hash;
  }

  function generate_hash($str) {
    # generate a 10 character hash
    return substr(md5($str), 0, 10);
  }

  function render() {
    # return the contents of the cachefile
    global $time_pre;
    header('X3-Page: [cache] ' . (microtime(true) - $time_pre) . ' seconds.');
    return file_get_contents($this->cachefile);
  }

  function delete_old_caches() {
    # collect a list of all cache files matching the same file_path hash and delete them
    $old_caches = glob(Config::$cache_folder.'/pages/'.$this->cache_prefix.$this->path_hash.'-*', GLOB_NOSORT);
		if($old_caches && count($old_caches)) {
			foreach($old_caches as $file) @unlink($file);
		}
  }

  function create($route, $file_path, $current_page = false, $include = true) {

  	$dir = Config::$cache_folder.'/pages';

  	# Create page cache folder if doesnt exist, or error
    if(!is_dir($dir)) {
      if(false === @mkdir($dir, 0777, true) && !is_dir($dir)) {
        throw new RuntimeException(sprintf("Unable to create the cache directory (%s).", $dir));
      }
    }

    # Make sure page cache folder is writeable, or error
    if(!is_writable($dir)) {
     	throw new RuntimeException(sprintf("Unable to write in the cache directory (%s).", $dir));
    }

  	# include scripts necessary for build process
  	if($include){
  		include './app/page-data.inc.php';
	  	include './app/menu.inc.php';
	  	include './app/asset-types/asset-factory.inc.php';
	  	include './app/asset-types/asset.inc.php';
	  	include './app/asset-types/image.inc.php';
	  	include './app/parsers/php-markdown-lib/Michelf/MarkdownExtra.inc.php';
			include './app/parsers/template-parser.inc.php';
			include './app/parsers/Twig/Autoloader.inc.php';
			include './app/extensions/twig-extensions.inc.php';
			include './app/extensions/twig.imagevue.inc.php';
			include './app/extensions/exif_reader.php';
  	}

    # remove any unused caches for this route
    $this->delete_old_caches();

    # create page
    $page = new Page($route, false, $file_path, $current_page, $this->is_protected);

    # output
    $data = $page->parse_template();
    global $time_pre;
    header('X3-Page: [created] ' . (microtime(true) - $time_pre) . ' seconds.');
    echo $data;

    # write to cache
    if(!$page->data['bypass_cache']) {
      file_put_contents($this->cachefile, $data);
      if($current_page && $route !== 'custom/404') $this->auto_cache($page, $data);
    }
  }

  function expired() {
    # check whether the cachefile matching the collated hashes exists
    return !file_exists($this->cachefile);
  }

  function auto_cache($page, $data) {

    // conditions: preload === auto && page.json && !protected
    if(X3Config::$config["settings"]["preload"] !== 'auto' || $page->template_file !== './app/twig/page.json' || $this->is_protected) return false;

    // vars
    $cache_file = './content/auto-cache.json';
    $exists = @file_exists($cache_file);
    $writeable = ($exists && @is_writable($cache_file)) || (!$exists && @is_writable('./content'));
    
    // not writeable or cache > 2mb
    if(!$writeable || @filesize($cache_file) > 2000000) return false;

    // append page json fragment
    $permalink = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/' . ltrim($page->data['permalink'], '/');
    //$permalink = '/' . ltrim($page->data['permalink'], '/');
    $outdated = $exists && (filemtime($cache_file) < $page->data['site_updated']);
    $json_content = $exists && !$outdated ? @file_get_contents($cache_file) : false;
    $is_empty = empty($json_content);
    $json_content = $is_empty ? '' : rtrim($json_content, '}');
    $json_content .= ($is_empty ? '{"' : '},"') . $permalink . '":' . $data . '}';
    file_put_contents($cache_file, $json_content);
  }

  /*function write_cache($data) {
    $fp = fopen($this->cachefile, 'w');
    fwrite($fp, $data);
    fclose($fp);
  }*/

}
?>
