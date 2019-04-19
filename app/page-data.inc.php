<?php

global $site;
$site = array();
use \Michelf\MarkdownExtra;

Class PageData {

  static $shared = false;
  //static $site_updated = false;
  static $page_root = false;
  //static $current_parent = false;
  //static $current_siblings = false;
  static $is_site;
  static $base_url;
  static $protect = true;
  static $hide = false;

  /*static function extract_closest_siblings($siblings, $file_path) {
    $neighbors = array();
    # flip keys/values
    $siblings = array_flip($siblings);
    # store keys as array
    $keys = array_keys($siblings);
    $keyIndexes = array_flip($keys);

    if(!empty($siblings) && isset($siblings[$file_path])) {
      # previous sibling
      if(isset($keys[$keyIndexes[$file_path] - 1])) $neighbors[] = $keys[$keyIndexes[$file_path] - 1];
      else $neighbors[] = false;
      # next sibling
      if(isset($keys[$keyIndexes[$file_path] + 1])) $neighbors[] = $keys[$keyIndexes[$file_path] + 1];
      else $neighbors[] = false;
    }
    return !empty($neighbors) ? $neighbors : array(false, false);
  }*/

  static function get_parent($file_path, $url) {
    # split file path by slashes
    $split_path = explode('/', $file_path);
    # drop the last folder from the file path
    array_pop($split_path);
    $parent_path = array(implode('/', $split_path));
    return $parent_path[0] == Config::$content_folder ? array() : $parent_path;
  }

  // X3 get path protected from config/protect
  static function get_protected($route) {

  	# get protect object
  	global $protect_ob;

  	# Only continue if access is not empty
    if(empty($protect_ob) || !isset($protect_ob["access"]) || empty($protect_ob["access"])) {
    	self::$protect = false;
    	return;
    }

    # check
  	$protected = false;
  	foreach($protect_ob["access"] as $key => $value) {
  		$item = rtrim($key,"/*");
  		if(substr($route, 0, strlen($item)) === $item){
  			$protected = "recursive";
  			break;
  		}
		}
    return $protected;
  }

  static function create_vars($page, $current_page = false, $is_file = false) {

		# page.file_path
    $page->data['file_path'] = $page->file_path;

    # page.permalink
    $page->permalink = $page->url_path == 'index' ? '' : $page->url_path.'/';

    # page.slug
    $page->slug = basename($page->url_path);

    # page.updated
    $updated = @filemtime($page->file_path);
    $page->updated = $updated;

    // convert page 'date' to timestamp if set, or set date from filemtime;
    if(isset($page->data['date'])){
    	$strtotime = @strtotime($page->data['date']);
    	if($strtotime) $page->date = $strtotime;
    } else {
    	$page->date = $updated;
    }

    # page.children_count
    if(!$is_file && basename($page->template_file) !== 'menu.html') $page->children_count = strval(count($page->data['children']));

    # page.domain_name
    $page->domain_name = $_SERVER['HTTP_HOST'];

    # page.base_url
    if(empty(self::$base_url)) self::$base_url = $_SERVER['HTTP_HOST'].str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
    $page->base_url = self::$base_url;
	  //$page->base_url = $_SERVER['HTTP_HOST'].str_replace('/index.php', '', $_SERVER['PHP_SELF']);

	  # page.id
    $page->id = "p" . substr(md5($_SERVER['HTTP_HOST'] . $page->data['permalink']), 0, 6);

    if(!$is_file) {
	    # x3 title
	    $title = empty($page->data['title']) ? ucwords(preg_replace('/[-_]/', ' ', $page->data['slug'])) : strip_tags($page->data['title'], '<a><span><em><i><b><strong><small><s><mark>');
	    $page->data['title'] = $title;
	    $page->data['sort_title'] = $title;
	    //$page->data['title'] = empty($page->data['title']) ? ucwords(preg_replace('/[-_]/', ' ', $page->data['slug'])) : strip_tags($page->data['title'], '<a><span><em><i><b><strong><small><s><mark>');

	    # x3 label
	    $page->data['label'] = empty($page->data['label']) ? ucwords(preg_replace('/[-_]/', ' ', $page->data['slug'])) : strip_tags($page->data['label']);

	    # x3 description
	    if(!empty($page->data['description'])) $page->data['description'] = strip_tags($page->data['description'], '<a><span><em><i><b><strong><small><s><br><mark><img><kbd><code><button>');
	  }

    # only $current_page and siteobject
		if($current_page || self::$is_site) {

	    # page.current_year
	    $page->current_year = date('Y');

	    # X3 get page protected
    	//$page->protected = self::get_protected(Helpers::modrewrite_parse($page->url_path));
    	if($page->is_protected){
    		$page->protected = $page->is_protected;
    	} else if($page->url_path === 'examples/features/password') {
    		$page->protected = 'recursive';
    	} else if(self::$is_site && self::$protect){
    		$page->protected = self::get_protected($page->url_path);
    	}

    	# page.x3_version
	    $page->x3_version = X3::$version;

	    # page.site_updated
	    //if(!self::$site_updated) self::$site_updated = Helpers::site_last_modified();
	    //$page->site_updated = self::$site_updated;
      $page->site_updated = Helpers::site_last_modified();

    	# page.siblings_count
	    //$page->siblings_count = strval(count($page->data['siblings_and_self']));

	    # page.index

	    # page.template_name
	    $page->data['template_name'] = $page->template_name;

		}

    # page.cache_page
	  $page->bypass_cache = isset($page->data['bypass_cache']) && $page->data['bypass_cache'] !== 'false' ? $page->data['bypass_cache'] : false;
  }

  static function create_collections($page, $current_page = false, $is_file = false) {

  	$template_file = basename($page->template_file);

  	# page.root (only used for site object, xml and atom)
  	if(self::$is_site || $template_file === 'sitemap.xml' ||  $template_file === 'feed.atom') {
  		if(!self::$page_root) self::$page_root = Helpers::list_files(Config::$content_folder, false, true);
	  	$page->root = self::$page_root;
  	}

    # only $current_page and siteobject
		if($current_page || self::$is_site){

	    # page.query
	    $page->query = $_GET;

	    /*
	    # page.parent
	    $dirname = dirname($page->file_path);
	    $parent_path = $dirname == Config::$content_folder ? array() : array($dirname);
	    $page->parent = $parent_path;

	    # page.siblings
	    $parent_path = !empty($parent_path[0]) ? $parent_path[0] : Config::$content_folder;

	    # page.siblings_and_self
	    if(self::$current_parent !== $parent_path) {
	    	self::$current_parent = $parent_path;
	    	self::$current_siblings = Helpers::list_files($parent_path, false, true);
	    }
	    $page->siblings_and_self = self::$current_siblings;

	    # page.next_sibling / page.previous_sibling
	    if(!$is_file) {
		    $neighboring_siblings = self::extract_closest_siblings($page->data['siblings_and_self'], $page->file_path);
		    $page->previous_sibling = array($neighboring_siblings[0]);
		    $page->next_sibling = array($neighboring_siblings[1]);
	  	}
	  	*/
	  }

	  # page.children
	  //if(!$is_file) $page->children = Helpers::list_files($page->file_path, '/^\d+?\./', true);
	  //if(!$is_file) $page->children = Helpers::list_files($page->file_path, null, true, false);
	  if(!$is_file && $template_file !== 'menu.html') {
	  	$page->children = Helpers::list_files($page->file_path, false, true);
	  }
  }

  static function create_asset_collections($page, $current_page = false) {

  	// load?
  	$load = empty($page->data['gallery']['assets']) && $page->data['gallery']['hide'] === false && strpos($page->data['layout']['items'], 'gallery') !== false && basename($page->template_file) !== 'menu.html';

    # page.images
    if($load) {

    	if(self::$hide === false){
	    	$hide = X3Config::$config['settings']['hide_images'];
	    	if($hide === 'double') {
	    		self::$hide = '(?!__)';
	    	} else if($hide === 'single'){
	    		self::$hide = '(?!_)';
	    	} else {
	    		self::$hide = '';
	    	}
    	}

    	// get page images
    	$page_images = Helpers::list_files($page->file_path, '/^' . self::$hide . '(?:[^.\n]*\.)*(?<!^preview\.|^thumb\.)(?:jpe?g|png|gif)$/i', false);

    	// filter hidden if not current page (for images count). Current page images are filtered in twig.extensions sortby()
    	if(!$current_page && !empty($page_images)){
    		foreach ($page_images as $name => $path) {
    			$name_lower = strtolower($name);
    			if(isset($page->data[$name_lower]['hidden']) && !empty($page->data[$name_lower]['hidden'])) unset($page_images[$name]);
    		}
    	}
    	$page->images = $page_images;

    	// get from IPTC too slow!
  		/*$page_images = array_filter($page->data['images'], function($img){
  			$img_data = @getimagesize($img, $info);
  			if(isset($info["APP13"])) {
		      $iptc = iptcparse($info["APP13"]);
		      return !isset($iptc["2#219"][0]) || empty($iptc["2#219"][0]);
		      //if(isset($iptc["2#219"][0])) $this->data['hidden'] = !empty($iptc["2#219"][0]);
		    }
		  	return true;
		  	//if(isset($page->data[$img])) var_dump($page->data[$img]);
		  	var_dump($img);
		  	return true;//!isset($page->data[$img]['hidden']) || empty($page->data[$img]['hidden']);
		  });*/

		  # page.video
    	if($current_page || self::$is_site) $page->video = Helpers::list_files($page->file_path, '/^' . self::$hide . '(?:[^.\n]*\.)*(?:mov|mp4|m4v)$/i', false);
    }

    # page.swf, page.html, page.doc, page.pdf, page.mp3, etc.
    # create a variable for each file type included within the page's folder (excluding .yml files)
    // required for mp3!
    /*$assets = self::get_file_types($page->file_path);
    foreach($assets as $asset_type => $asset_files) {
      $page->$asset_type = $asset_files;
    }*/
  	//}
  }

  # What's this?
  /*static function preparse_text($text) {
    $content = preg_replace_callback('/:\s*(\n)?\+{3,}([\S\s]*?)\+{3,}/', create_function('$match',
      'return ": |\n  ".preg_replace("/\n/", "\n  ", $match[2]);'
    ), $text);
    return $content;
  }*/

  static function create_textfile_vars($page, $content = false, $current_page = false) {

  	# Parent template file
    global $current_page_template_file;
    if(!$current_page_template_file) $current_page_template_file = $page->template_file;

  	# is site.json?
  	if(empty(self::$is_site)) self::$is_site = $current_page_template_file === Config::$templates_folder.'/site.json' ? true : false;

    # JSON
    $json_file = $page->file_path . '/' . $page->template_name . '.json';
    if($page->template_name === 'page' && file_exists($json_file)){
    	$json_content = file_get_contents($json_file);
    	$json = (!empty($json_content)) ? json_decode($json_content, TRUE) : array();
    	$vars = array_replace_recursive(X3Config::$config, $json);
    } else {
    	$json = array();
    	$vars = X3Config::$config;
    }

    # Vars merge
    if(empty($vars)) return;

    # Redirect as early as possible and exit if link and currentpage
    if($current_page && !empty($vars['link']['url'])) Helpers::redirect($vars['link']['url']);

    # only current_page or siteobject
    if($current_page || self::$is_site) {

    	# Populate site object
    	global $site;
	    $site["page".$page->file_path] = $json;

	    # parse_vars
	    $markdown_compatible = preg_match('/\.(xml|html?|rss|rdf|atom|js|json)$/', $current_page_template_file);
	    //$relative_path = preg_replace('/^\.\//', Helpers::relative_root_path(), $page->file_path);
	    # x3 fix rootpath
	    $root_path = preg_replace('/(\/+)/','/',str_replace('/index.php','',$_SERVER['PHP_SELF'])) . str_replace('./','/',$page->file_path);

	    $vars = self::parse_vars($vars, $markdown_compatible, $root_path);
  	}

  	# Add vars to page
    foreach ($vars as $key => $value) {
      # set a variable with a name of 'key' on the page with a value of 'value'
      $page->$key = $value;
    }
  }

  static function parse_vars($vars, $markdown_compatible, $root_path = null) {
    foreach ($vars as $key => $value) {
      # replace the only var in your content - page.path for your inline html with images and stuff
      //if (is_string($value)) $value = preg_replace('/{{\s*path\s*}}/',  $relative_path . '/', $value);
      // x3 fix rootpath
      if(is_string($value)) $value = preg_replace('/{{\s*path\s*}}/',  $root_path . '/', $value);

      # if the template type is markdown-compatible & the 'value' contains a newline character, parse it as markdown
      if(!is_string($value)) {
        $vars[$key] = $value;
      } else if ($key == 'content' && $markdown_compatible) {
        $vars[$key] = MarkdownExtra::defaultTransform(trim(preg_replace('/<!--[^-]*(?:-(?!->)[^-]*)*-->(?!<br>)/s', '', $value)));
        //$vars[$key] = MarkdownExtra::defaultTransform(trim(preg_replace('/[$ ]<!--.*?-->/s', '', $value)));
        //$vars[$key] = MarkdownExtra::defaultTransform(trim($value));
      } else {
        $vars[$key] = trim($value);
      }
    }
    return $vars;
  }

  static function html_to_xhtml(&$value) {
    if (!is_string($value)) return;

    # convert named entities to numbered entities
    $value = Helpers::translate_named_entities($value);
    # convert appropriate markdown-created tags to xhtml syntax
    $value = preg_replace('/<(br|hr|input|img)(.*?)\s?\/?>/', '<\\1\\2 />', $value);

    return $value;
  }

  static function create($page, $content = false, $current_page = false, $is_file = false) {

  	global $current_page_template_file;
  	$template = basename($current_page_template_file);

    # set vars created within the text file
    self::create_textfile_vars($page, $content, $current_page);

    # create each of the page-specfic helper variables
    self::create_collections($page, $current_page, $is_file);
    self::create_vars($page, $current_page, $is_file);
    if($template !== 'sitemap.xml' && $template !== 'feed.atom' && $template !== 'menu.html' && !$is_file) self::create_asset_collections($page, $current_page);

    # if file extension matches an xml type, convert to any html to xhtml to pass validation
    if(preg_match('/\.(xml|rss|rdf|atom)$/', $current_page_template_file)) {
      # clean each value for xhtml rendering
      foreach($page->data as $key => $value) {
        if (is_string($value)) {
          $page->data[$key] = self::html_to_xhtml($value);
        }
      }
    }
  }

}

?>
