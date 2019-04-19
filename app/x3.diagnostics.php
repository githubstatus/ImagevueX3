<?php

// display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# Never proxy-cache diagnostics
header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0, s-maxage=0');
header('Pragma: no-cache');

# Warning and exit if PHP < 5.3
if(version_compare(PHP_VERSION, '5.3.0', '<')){
	include 'x3.php-outdated.php';
	exit();

# Make sure is called from X3 index.php app and $show_x3_diagnostics != false
} else if(!isset($show_x3_diagnostics) || (isset($show_x3_diagnostics) && !$show_x3_diagnostics)){
	exit();
}

// vars
$server_protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? "https://" : "http://";
define('ABSOLUTE', (string)trim($server_protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']),'/'));
$x3_version = class_exists('X3') ? X3::$version : null;
$x3_version_date = class_exists('X3') ? X3::$version_date : null;
$x3_buster = $x3_version ? '?v=' . $x3_version : '';
$posted = $_SERVER["REQUEST_METHOD"] == "POST" 
	&& isset($_SERVER['HTTP_REFERER']) 
	&& stripos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) !== false 
	&& isset($_POST['get-x3-diagnostics']);

// POST
if($posted){

	# Vars
	$file_path = dirname(__DIR__);
	$link_path = dirname($_SERVER['PHP_SELF']) == '/' ? '' : dirname($_SERVER['PHP_SELF']);
	$custom_dir_path = './content/custom';
	$rewrite_base = dirname($_SERVER["SCRIPT_NAME"]);
	$cache_folders = array('pages','images/rendered','images/request');
	$critical = (string)"";
	$success = (string)"";
	$warning = (string)"";
	$info = (string)"";
	$output = (string)"";
	$basedir_str = ini_get('open_basedir');
	$open_basedir = !empty($basedir_str);
	$htaccess_allowed = true;
	$x3_diagnostics = isset(X3Config::$config) && X3Config::$config["settings"]["diagnostics"] ? true : false;
	$index_dirs = glob('./content/*index', GLOB_NOSORT|GLOB_ONLYDIR);
	$php_interface = function_exists('php_sapi_name') ? php_sapi_name() : false;
	$php_apache = !empty($php_interface) && stripos($php_interface, 'apache') !== false ? true : false;

	# $_SERVER['X3_STOP_DIAGNOSTICS'] (only works if diagnostics is disabled from panel else it will cause loop)
	if(isset($_SERVER['X3_STOP_DIAGNOSTICS']) && !$x3_diagnostics) {
		header('Location: ' . ABSOLUTE . '/');
		exit();
	}

	# server
	$server_software = isset($_SERVER['SERVER_SOFTWARE']) && $_SERVER['SERVER_SOFTWARE'] ? $_SERVER['SERVER_SOFTWARE'] : false;
	$supported_servers = array("apache", "iis", "nginx", "lighttpd", "caddy", "litespeed");
	if($server_software){
		foreach ($supported_servers as &$value) {
			if(stripos($server_software, $value) !== false) {
				$server_software = $value;
				break;
			}
		}
	}

	# Apache-like server litespeed and apache
	$server_is_like_apache = $server_software === "litespeed" || $server_software === "apache" ? true : false;

	# Get Apache Modules
	ob_start();
	phpinfo(INFO_MODULES);
	global $phpinfo;
	$phpinfo = ob_get_clean();


	### FUNCTIONS ###

	// Add item to output
	function addItem($status, $title, $description){
		$str = '<div class="x3-diagnostics-item x3-diagnostics-' . $status . '">';
		if(!empty($title)) $str .= '<strong>' . $title . '</strong>';
		$str .= '<div class=x3-diagnostics-description>' . $description . '</div></div>';
		return $str;
	}

	// delete dir recursively
	function deleteDirectory($dir) {
		$dirPath = $dir;
		if(file_exists($dirPath) && is_dir($dirPath)) {
			$iterator = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
			$files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);
			foreach($files as $file) {
				if($file->isDir()) {
					@rmdir($file->getRealPath());
				} else {
					@unlink($file->getRealPath());
				}
			}
			return @rmdir($dir);
		}
		return false;
	}

	# mkdir if is missing
	function mkdir_if_missing($path){
		if(!file_exists($path)) {
			global $success;
			$created = @mkdir($path, 0777, true);
			if($created) {
				$success .= addItem('success', 'Directory Created', 'We have successfully added the <code>' . trim($path, '.') . '</code> directory.');
				return true;
			}
			return false;
		}
		return true;
	}

	# Check php ini on
	function checkPhpIniOn($name){
		$value = ini_get($name);
		if (empty($value)) {
			return false;
		}
		return ((integer)$value == 1 || strtolower($value) == 'on');
	}

	# http file exists
	function httpFileExists($file){
		if(function_exists('get_headers')){
			$headers = @get_headers($file);
			return stripos($headers[0], '404 not found') === false && stripos($headers[0], '500 internal server error') === false ? true : false;
		} else {
			return true;
		}
	}

	# Get server env
	function getServerEnv($env){
		return !empty($_SERVER[$env]) ? $_SERVER[$env] : 'undefined';
	}

	# Checks if has Apache Module
	function hasApacheModule($module){
		global $phpinfo;
		if(function_exists('apache_get_modules')) {
			return in_array($module, apache_get_modules());
		} else if(strpos($phpinfo, $module) !== false){
			return true;
		}
		return false;
	}

	# Make sure /config/ folder is blocked (assume blocked if get_headers() function doesn't exist, because we can't check)
	$config_blocked = !@function_exists('get_headers');
	if(!$config_blocked){

		// files exist before checking
		$config_blocked_test = file_exists($file_path . '/config/config.user.json') ? '/config/config.user.json' : (file_exists($file_path.'/config/readme.txt') ? '/config/readme.txt' : false);

		// proceed if file exists
		if($config_blocked_test) {

			// get file headers
			$test_config_readable = @get_headers(ABSOLUTE . $config_blocked_test);

			// assume config is blocked if response !== "HTTP/1.1 200 OK"
			if(empty($test_config_readable) || strpos($test_config_readable[0], '200') === false) $config_blocked = true;

		// if files don't exist, assume config is blocked
		} else {
			$config_blocked = true;
		}
	}

	# Get rewrite flags
	$mod_rewrite_working = false;
	$mod_rewrite_confirmed = false;
	$has_mod_rewrite = false;
	function get_rewrite_flags(){

		# global vars
		global $mod_rewrite_working, $mod_rewrite_confirmed, $has_mod_rewrite;

		# Check if REWRITE is working
		# First check if we can use get_headers() to test for rewrite
		if(function_exists('get_headers')) {

			# check image /render/ (even if bad request)
			$fav = glob('./content/custom/favicon/*.png', GLOB_NOSORT);
			$check_file = ABSOLUTE . '/render/' . ($fav && count($fav) ? 'w/custom/favicon/' . basename(end($fav)) : 'nada.jpg');
			$mod_rewrite_working = httpFileExists($check_file) ? true : false;

			# double check
			if(!$mod_rewrite_working){
				if(file_exists('./content/custom/404/page.json')){
					$mod_rewrite_working = httpFileExists(ABSOLUTE.'/custom/404.json') ? true : false;

				# Last resort, test if we get 'application/json' for failed request
				} else {
					$test1 = @get_headers(ABSOLUTE.'/x3test.json');
					$test1_string = implode(',', $test1);
					$mod_rewrite_working = stripos($test1_string, 'application/json') !== false ? true : false;
				}
			}

			# Set $mod_rewrite_confirmed
			$mod_rewrite_confirmed = $mod_rewrite_working;

		# Else we just need to assume rewrite is working
		} else {
			$mod_rewrite_confirmed = false;
			$mod_rewrite_working = true;
		}

		# Check for rewrite module enabled
		if($mod_rewrite_confirmed){
			$has_mod_rewrite = true;
		} else if(isset($_SERVER["HTTP_MOD_REWRITE"])){
			$has_mod_rewrite = true;
		} else if(hasApacheModule('mod_rewrite')) {
			$has_mod_rewrite = true;
		} else if(function_exists('shell_exec') && strpos(shell_exec('/usr/local/apache/bin/apachectl -l'), 'mod_rewrite') !== false) {
			$has_mod_rewrite = true;
		} else {
			$has_mod_rewrite = false;
		}
	}

	# run get_rewrite_flags immediately
	get_rewrite_flags();

	# Successful non-htaccess server config
	if($mod_rewrite_confirmed) {

		# Successfull Apache (only if !htaccess of X3_SERVER_CONFIG)
		if($server_is_like_apache) {
			if(!file_exists($file_path.'/.htaccess') || isset($_SERVER["X3_SERVER_CONFIG"])) {
				$success .= addItem('success', ucfirst($server_software) . ' X3 config detected', 'Congratulations! It seems you have successfully configured X3 from your ' . ucfirst($server_software) . ' server config.');
			}

		# Successful server config generic (NGINX, Lighttp etc)
		} else if($server_software !== 'iis'){
			$success .= addItem('success', 'Server config detected [' . ucfirst($server_software) . ']', 'Congratulations! It seems you have successfully configured X3 from your ' . ucfirst($server_software) . ' server config.');
		}
	}

	# Add link to attempt to path htaccess with rewriteBase
	function patchHtaccesslink(){
		global $x3_diagnostics;
		if(!isset($_GET["htaccess_patch"]) && file_exists('./.htaccess') && is_writable('./.htaccess') && $x3_diagnostics) {
			$url = isset($_GET["diagnostics"]) ? '?diagnostics&htaccess_patch' : '?htaccess_patch';
			return '<br><a class="button" href="' . $url . '">Automatically apply patch</a>';
		}
		return false;
	}

	# Add info to output
	function addInfo($title, $description, $state = ''){
		if($state === false) {
			$class = 'bad';
		} else if($state === true){
			$class = 'good';
		} else {
			$class = '';
		}
		return '<tr class="' . $class . '"><td class="info-title">' . $title . '</td><td class="info-description">' . $description . '</td></tr>';
	}

	# infoheader function for info table
	function infoHeader($header){
		return '<tr class="info-header"><td colspan="2">' . $header . '</td></tr>';
	}


	### INITIALIZATION ###			

	# Check that cache exists
	if(!mkdir_if_missing(Config::$cache_folder)){
		$critical .= addItem('danger', 'Missing Cache Folder', 'It seems you are missing the required <code>_cache</code> directory, and we could not create it automatically. This folder is required so that X3 can save resized images and cache pages.');

	# /_cache exists, try to write .htaccess to /_cache dir
	} else if($server_is_like_apache && !isset($_SERVER["X3_SERVER_CONFIG"]) && is_writable(Config::$cache_folder) && !file_exists(Config::$cache_folder . '/.htaccess') && file_exists('./app/resources/deny.htaccess')){
		$copied = @copy('./app/resources/deny.htaccess', Config::$cache_folder . '/.htaccess');
		if($copied) $success .= addItem('success', '_cache directory protected', 'We have successfully added a <code>.htaccess</code> file in your <code>_cache</code> directory to prevent files within from being accessed directly from the web.');
	}

	# Cache dirs
	if(file_exists(Config::$cache_folder)){

		# Check that cache is writeable
		if(!is_writable(Config::$cache_folder)){
			$critical .= addItem('danger', 'Cache folder not writeable', 'You need to set write permissions on the <code>_cache</code> directory. This folder needs to be writeable so that X3 can save resized images and cache pages.');

		# Check that cache is writeable
		} else {

			// loop _cache/* folder-passwords
			foreach ($cache_folders as &$value) {

				// Create cache folders if they don't exist
				if(!mkdir_if_missing(Config::$cache_folder.'/'.$value)){
					$critical .= addItem('danger', 'Can\'t create cache folder', 'Can\'t create <code>' . trim(Config::$cache_folder, '.') . '/' . $value . '</code> either because of <code>safe_mode</code> or permissions.');

				// if created or already exist, check writeable
				} else if(!is_writable(Config::$cache_folder.'/'.$value)){
					$critical .= addItem('danger', 'Cache folder not writeable', 'Folder <code>' . trim(Config::$cache_folder, '.') . '/' . $value . '</code> is not writeable. This folder needs to have write permissions so that X3 can cache pages and resized images.');
				}
			}
		}
	}

	// LEGACY X3.23.0 :: Remove unused app/_cache
	if(file_exists('app/_cache')){
		deleteDirectory('app/_cache/images/request');
		if(deleteDirectory('app/_cache')) {
			$success .= addItem('success', 'Removed /app/_cache', 'Successfully removed unused <code>/app/_cache</code> directory.');
		} else {
			$warning .= addItem('warning', 'Failed to remove /app/_cache', 'Failed to remove some items in <code>/app/_cache</code>. It is recommended to delete this unused directory by FTP.');
		}
	}

	// LEGACY X3.23.0 :: Remove various unused directories
	$unused_dirs = array('extensions', 'templates', /*'public',*/ 'content/feed', 'content/json', /*'content/services',*/ /*'content/sitemap',*/ 'content/custom/css', 'content/custom/footer', 'content/custom/head', 'content/custom/header', 'content/custom/javascript', 'content/custom/mail', 'content/custom/widget.contact', 'diag/', 'check/');
	if($_SERVER['HTTP_HOST'] !== 'macbook.local' && $_SERVER['HTTP_HOST'] !== 'x3') $unused_dirs[] = '.sass-cache/';
	foreach($unused_dirs as $unused_dir) {
		if(deleteDirectory($unused_dir)) $success .= addItem('success', 'Removed ' . $unused_dir, 'Successfully removed unused <code>' . $unused_dir . '</code> directory.');
	}

	# LEGACY X3.23.0 :: Create new /custom/* folders
	if(file_exists($custom_dir_path)){
		$custom_dir_path_writeable = is_writable($custom_dir_path);
		if($custom_dir_path_writeable){
			$custom_dirs = array('files', 'files/css', 'files/images', 'files/javascript');
			foreach($custom_dirs as $custom_dir) {
				mkdir_if_missing($custom_dir_path . '/' . $custom_dir);
			}
		}
	}


	### CRITICAL ###


	# Check PHP version
	if(phpversion() < 5.3) {
		$critical .= addItem('danger', 'PHP Version 5.3+ required', 'X3 requires PHP 5.3 or higher, and you are currently running PHP version ' . phpversion() . '.');
	}

	# Check config is populated
	if(empty(X3Config::$config) || empty(X3Config::$config["settings"])) {
		$critical .= addItem('danger', 'Invalid X3 Config', 'The X3 configuration object seems to be empty. Did you upload all files?');
	}

	# function check_htaccess
	function apache_check_htaccess($first_check = true, $patching = false){

		# global vars
		global $file_path, $warning, $rewrite_base, $htaccess_allowed, $critical, $success, $link_path, $has_mod_rewrite, $mod_rewrite_working, $mod_rewrite_confirmed, $server_software, $config_blocked, $server_is_like_apache, $x3_diagnostics;

		# Patching attempted
		if($patching){
			if($mod_rewrite_working){
				$success .= addItem('success', 'Successfully patched .htaccess!', 'Patching the root .htaccess file with the following line seems to fix mod_rewrite for your server:<br><br><code>RewriteBase ' . $rewrite_base . '</code><br><br><em>* You should take note that your server requires the rule above when upgrading X3.</em>');
			} else {
				$critical .= addItem('danger', 'RewriteBase Patch Failed', 'Although the rule <code>RewriteBase ' . $rewrite_base . '</code> was successfully applied to the .htaccess file, it does not seem to have any effect on rewrite rules :(');
			}
		}

		# only proceed if apache and mod_rewrite is not working
		if($server_is_like_apache && !$mod_rewrite_confirmed){

			// get current rewritebase
			$current_rewritebase = false;
			if(file_exists('.htaccess') && is_readable('.htaccess')){
				$htaccess_lines = @file('.htaccess', FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
				if($htaccess_lines){
					$rewritebase_lines = preg_grep("/^RewriteBase/", array_map('trim', $htaccess_lines));
					if(count($rewritebase_lines)) {
						$rewritebase_val = explode(' ', trim(str_replace('RewriteBase', '', end($rewritebase_lines))));
						$current_rewritebase = $rewritebase_val[0];
					}
				}
			}

			# .htaccess doesn't exist
			if(!file_exists($file_path.'/.htaccess')){

				# Attempt to copy .htaccess from default.htaccess
				$copied = false;
				if($first_check && is_writable($file_path) && file_exists('./app/resources/x3.htaccess')){
					$copied = @copy('./app/resources/x3.htaccess', '.htaccess');
				}

				# check if copy was successfull, re-run function
				if($copied){
					$success .= addItem('success', '.htaccess created', 'The X3 <code>.htaccess</code> config file for ' . $server_software . ' was missing, but we have created it for you.');
					get_rewrite_flags();
					apache_check_htaccess(false);

				# failed to create .htaccess, display warning
				} else {
					$critical .= addItem('danger', 'Missing .htaccess', 'It seems you are missing the required <strong>.htaccess</strong> file in your root directory. You can copy the file <code>/app/resources/x3.htaccess</code> into root, and rename it to <code>.htaccess</code>.');
				}

			# Check htaccess allowed
			} else if(file_exists($file_path.'/config/.htaccess') && !$config_blocked && !isset($_SERVER["HTTP_MOD_REWRITE"])) {
				$critical .= addItem('danger', $server_software . ' .htaccess AllowOverride None', 'It seems your ' . $server_software . ' config <a href="https://httpd.apache.org/docs/2.4/mod/core.html#allowoverride" target="_blank">AllowOverride</a> is set to <code>AllowOverride None</code>, which does not allow rules from <code>.htaccess</code> files. X3 depends on custom rules set in the htaccess file to rewrite and create nice URL\'s for your X3 website. You need to set <code>AllowOverride All</code>.<br>Read more in <a href="http://stackoverflow.com/questions/18740419/how-to-set-allowoverride-all" target="_blank">this post</a>.<br><br>If you have access to Apache configuration file, you can <a href="https://gist.github.com/mjau-mjau/f4acd76bef4c1d33fba22913a9ff488e" target="_blank">add rules directly</a>.');
				$htaccess_allowed = false;

			// auto-patch
			} else if(!isset($_GET["htaccess_patch"]) && is_writable('./.htaccess') && $has_mod_rewrite && !$mod_rewrite_working && (!$current_rewritebase || $current_rewritebase !== $rewrite_base) && @file_put_contents('.htaccess', PHP_EOL . PHP_EOL . '# Added by x3 diagnostics on ' . date('r') . PHP_EOL . 'RewriteBase ' . $rewrite_base . PHP_EOL, FILE_APPEND)){
				get_rewrite_flags();
				if($mod_rewrite_working){
					$success .= addItem('success', 'Successfully added RewriteBase ' . $rewrite_base, 'We added the following line to your <strong>.htaccess</strong> file, which allows X3 <a href="http://httpd.apache.org/docs/current/mod/mod_rewrite.html" target="_blank">rewrite</a> rules to work properly:<br><br><code>RewriteBase ' . $rewrite_base . '</code>');
				} else {
					$warning .= addItem('warning', 'Mod_rewrite not working as expected', 'Although we have successfully detected the <a href="http://httpd.apache.org/docs/current/mod/mod_rewrite.html" target="_blank">mod_rewrite</a> extension on your server, it does not seem to be working as expected. This extension is necessary in X3 for links to work, and for resized images to load. You may need to add the below to your root <strong>.htaccess</strong> file:<br><br><code>RewriteBase ' . $rewrite_base . '</code>' . patchHtaccesslink());
				}

			# Attempting to patch .htaccess with rewriteBase
			} else if(isset($_GET["htaccess_patch"]) && !$mod_rewrite_working && is_writable('./.htaccess') && $x3_diagnostics && !$patching){
				if(@file_put_contents('.htaccess', PHP_EOL . PHP_EOL . '# Added by x3 diagnostics on ' . date('r') . PHP_EOL . 'RewriteBase ' . $rewrite_base . PHP_EOL, FILE_APPEND)){
					get_rewrite_flags();
					apache_check_htaccess(false, true);
				} else {
					$warning .= addItem('danger', 'Cannot patch .htaccess', 'It seems our script is not allowed to write to the root <code>.htaccess</code>. You can try to edit it by opening the file in a text editor, and appending the line:<br><br><code>RewriteBase ' . $rewrite_base . '</code>');
				}

			# Mod rewrite detected, but not working as expected
			} else if($has_mod_rewrite && !$mod_rewrite_working){
				$warning .= addItem('warning', 'Mod_rewrite not working as expected', 'Although we have successfully detected the <a href="http://httpd.apache.org/docs/current/mod/mod_rewrite.html" target="_blank">mod_rewrite</a> extension on your server, it does not seem to be working as expected. This extension is necessary in X3 for links to work, and for resized images to load. You may need to add the below to your root <strong>.htaccess</strong> file:<br><br><code>RewriteBase ' . $rewrite_base . '</code>' . patchHtaccesslink());

			# Can't detect mod_rewrite at all
			} else if(!$has_mod_rewrite && !$mod_rewrite_working){
				$critical .= addItem('danger', 'Can\'t detect mod_rewrite', 'We cannot seem to detect the <a href="http://httpd.apache.org/docs/current/mod/mod_rewrite.html" target="_blank">mod_rewrite</a> extension on your server. This extension is necessary in X3 for links to work, and for resized images to load. There is a small chance your server has this extension, but we cannot detect it - You can check for this extension by going to <a href="' . $link_path . '/panel/" target="_blank">Panel</a> &rsaquo; tools &rsaquo; phpinfo, and searching the text for "mod_rewrite". If you are 100% certain your server has mod_rewrite, you can try to to add the following line to your root <strong>.htaccess</strong> file:<br><br><code>RewriteBase ' . $rewrite_base . '</code>' . patchHtaccesslink());
			}
		}
	}

	# Check that .htaccess exists (apache only)
	apache_check_htaccess();

	# Check that web.config exists (IIS only)
	if(!$mod_rewrite_confirmed && $server_software === 'iis' && !file_exists($file_path.'/web.config')) {
		$critical .= addItem('danger', 'Missing web.config', 'It seems you are missing the <code>web.config</code> file in your root X3 directory. This configuration file is necessary to run X3 on Microsoft IIS servers.');
	}

	# Check for APP/CONFIG.DEFAULTS.JSON
	if(!file_exists($file_path.'/app/config.defaults.json')){
		$critical .= addItem('danger', 'Missing config.defaults.json file', 'Where is your <code>/app/config.defaults.json</code> file? This file contains default X3 settings, and is strictly required.');
	}

	# Check for content folder
	if(!file_exists($file_path.'/content')){
		$critical .= addItem('danger', 'Where is your content folder?', 'Where did your <code>/content</code> folder go?');

	# content dir exists
	} else {

		# Check that /CONTENT/ folder is writeable
		$content_writeable = is_writeable($file_path . '/content');
		if(!$content_writeable){
			$warning .= addItem('warning', 'Content folder is not writeable', 'Your main <code>/content</code> folder is not writeable. You need to set write permissions on this folder if you want to use the X3 Panel to manage your website.');

		// Add content/.htaccess
		} /*else if($server_is_like_apache && !isset($_SERVER["X3_SERVER_CONFIG"]) && !file_exists('./content/.htaccess') && file_exists('./app/resources/deny.php.htaccess')){
			if(@copy('./app/resources/deny.php.htaccess', './content/.htaccess')) $success .= addItem('success', '/content/.htaccess created', 'We have created a .htaccess file inside your content directory that blocks PHP execution. There should not exist PHP files in your content directory, but this is just an additional layer of security.');
		}*/

		// folders.json
		if(!file_exists('./content/folders.json')){
			if(Helpers::refresh_folders()){
				$success .= addItem('success', 'folders.json created', 'Successfully created the <code>content/folders.json</code> data file.');
			} else {
				$critical .= addItem('danger', 'Failed to create folders.json', 'Failed to create <code>content/folders.json</code>' . (!$content_writeable ? ' because your <code>/content</code> directory is not writeable.' : '.'));
			}

		// folders.json not writeable
		} else if(!is_writable('./content/folders.json')){
			$warning .= addItem('warning', 'folders.json not writeable', 'The file <code>content/folders.json</code> needs to be writeable if you intend to manage your website from the X3 control panel.');
		}

		// auto-cache.json
		if(!file_exists('./content/auto-cache.json')){
			if($content_writeable && @touch('./content/auto-cache.json')){
				$success .= addItem('success', 'auto-cache.json created', 'Successfully created the <code>content/auto-cache.json</code> data file.');
			} else {
				$warning .= addItem('warning', 'Failed to create auto-cache.json', 'Failed to create <code>content/auto-cache.json</code>' . (!$content_writeable ? ' because your <code>/content</code> directory is not writeable.' : '.'));
			}
		} else if(!is_writable('./content/auto-cache.json')){
			$warning .= addItem('warning', 'auto-cache.json is not writeable', 'The file <code>content/auto-cache.json</code> needs to be writeable so that X3 can store cached pages.');
		}

		# check for content/custom folder
		if(!file_exists('./content/custom')){
			$warning .= addItem('warning', 'Missing Custom Directory', 'You seem to be missing the X3 <code>/content/custom/</code> directory.');
		}

		# Check default preview image is available in index directory
		if(count($index_dirs)){
			$index_dir = current($index_dirs);
			$index_dir_images = array_filter(glob($index_dir . '/*.*', GLOB_NOSORT), function($val){
    		return in_array(strtolower(pathinfo($val, PATHINFO_EXTENSION)), array('jpg','jpeg','png','gif'));
    	});
			if(!count($index_dir_images)) {
				$warning .= addItem('warning', 'Missing Default Preview Image', 'You don\'t seem to have any images uploaded in your <code>' . basename($index_dir) . '</code> folder. You should have at least one image <code>preview.jpg</code> uploaded there, which works as default preview image for any page that doesn\'t have their own preview image.');
			}

		# No index page exists!
		} else {
			$critical .= addItem('danger', 'Missing Index Home Page Folder', 'You don\'t seem to have an <code>index</code> folder in your content. The index folder is placeholder for your home page, and is therefore required. To solve the issue, go to panel and create a folder <code>1.index</code> in content root.');
		}
	}

	# GD Extension
	if(!extension_loaded('gd') || !function_exists('gd_info')){
		$critical .= addItem('danger', 'Missing PHP GD Extension', 'Your server PHP is missing the <a href="http://php.net/manual/en/image.installation.php" target="_blank">GD Extension</a>, which is required by X3 to resize images.');
	}

	// XML extension
	if(!extension_loaded('xml')){
		$critical .= addItem('danger', 'Missing PHP XML Extension', 'Your server is missing the required PHP <a href="http://php.net/manual/en/book.xml.php" target="_blank">XML extension</a>.');
	}

	// check session_save_path
	$session_save_path_original = session_save_path();
	$session_save_path = $session_save_path_original;
	$session_save_path_result = null; // for usage in values list

	// conditions: !empty !open_basedir !:// has/slash
	if(!empty($session_save_path) /*&& !$open_basedir*/ && strpos($session_save_path, '://') === false && strpos($session_save_path, '/') !== false){

		// fix '4;/gah/phpsessions' => '/gah/phpsessions'
		if(strpos($session_save_path, '/') !== 0) $session_save_path = strstr($session_save_path, '/');

		// session_save_path is blocked by open_basedir
		if($open_basedir && !@is_dir($session_save_path)) {
			$warning .= addItem('warning', 'PHP session.save-path directory is blocked by open_basedir.', 'Your server <a href="http://php.net/manual/en/session.configuration.php#ini.session.save-path" target="_blank">session.save_path</a> is set to <code>' . $session_save_path . '</code> but this directory is not within your <strong>open_basedir</strong> allowed paths. If you can\'t login to your X3 panel, it means X3 can\'t <strong>save</strong> the login-session, in which case you need to contact your host.');
			$session_save_path_result = false;

		} else {

			// path doesn't exist?
			if(!file_exists($session_save_path)) {
				$warning .= addItem('warning', 'PHP session.save-path directory does not exist.', 'Your server <a href="http://php.net/manual/en/session.configuration.php#ini.session.save-path" target="_blank">session.save_path</a> is set to <code>' . $session_save_path . '</code>, but this directory does not seem to exist. If you can\'t login to your X3 panel, it means X3 can\'t <strong>save</strong> the login-session, in which case you need to contact your host!');
				$session_save_path_result = false;

			// not writeable?
			} else if(!is_writable($session_save_path)){
				$warning .= addItem('warning', 'PHP session.save-path directory is not writeable.', 'Your server <a href="http://php.net/manual/en/session.configuration.php#ini.session.save-path" target="_blank">session.save_path</a> is set to <code>' . $session_save_path . '</code>, but this directory does not seem to be writeable. If you can\'t login to your X3 panel, it means X3 can\'t <strong>save</strong> the login-session, in which case you need to contact your host!');
				$session_save_path_result = false;
			}
		}
	}


	### WARNING ###

	# Recommend upgrading PHP 5.3
	if(phpversion() < 5.4 && phpversion() >= 5.3) {
		$warning .= addItem('warning', 'Deprecated PHP Version 5.3', 'Your server is running an old <strong>PHP version ' . phpversion() . '</strong>. Although X3 supports the PHP 5.3 branch, you should check in your hosting control panel if you can upgrade to a newer version of PHP, preferably latest PHP 7.x.<br><em>* Upgrading your PHP will ensure best compatibility, security and performance.</em>');

	// recommend update to PHP 7
	} else if(phpversion() < 7){
		$warning .= addItem('neutral', 'PHP Version ' . phpversion(), 'Your server is running an older <strong>PHP version ' . phpversion() . '</strong>. Although X3 will still work fine, we recommend upgrading to latest <strong>PHP 7.x</strong> for best compatibility, security and performance. Normally, you can login to your hosting control panel and update the PHP version from your PHP settings.');

	// PHP 7.3 bug (solved in 7.3.3 according to reports)
	} else if(X3Config::$config["back"]["use_iptc"] && version_compare(PHP_VERSION, '7.3') >= 0 && version_compare(PHP_VERSION, '7.3.3') < 0) {
		$warning .= addItem('warning', 'PHP ' . phpversion() . ' Bug', 'Your PHP version ' . phpversion() . ' has a <a href="https://bugs.php.net/bug.php?id=77546" target="_blank">bug</a> that could affect X3. See <a href="https://forum.photo.gallery/viewtopic.php?f=51&t=9732" target="_blank">this post</a> for more info.');
	}

	# Check database panel login
	if(X3Config::$config["back"]["panel"]["use_db"]) {
		if(empty(X3Config::$config["back"]["panel"]["db_host"]) || empty(X3Config::$config["back"]["panel"]["db_user"]) || empty(X3Config::$config["back"]["panel"]["db_pass"]) || empty(X3Config::$config["back"]["panel"]["db_name"])){
			$warning .= addItem('warning', 'Missing database details', 'You have enabled the database-version of the panel, but one or more database connection details are empty!');
		} else if(function_exists('mysqli_connect')){

			# DB vars
			$dbname = X3Config::$config["back"]["panel"]["db_name"];
			$dbuser = X3Config::$config["back"]["panel"]["db_user"];
			$dbpass = X3Config::$config["back"]["panel"]["db_pass"];
			$dbhost = X3Config::$config["back"]["panel"]["db_host"];

			# Check DB connection
			# https://www.daniweb.com/programming/web-development/code/434480/using-phpmysqli-with-error-checking
			$connection = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
			if($connection->connect_errno) {
				$msg = (string)$connection->connect_error;

				# Fail DB HOST
				if(strtolower($msg) === 'no such file or directory'){
					$warning .= addItem('warning', 'Panel Database Connection Fail', 'Failed to connect to Database HOST <strong>"' . $dbhost . '"</strong> (' . $msg . '). Try the X3 <a href="./panel/db_check.php" target="_blank">Database connection checker</a>.');

				# Generic DB connection error
				} else {
					$warning .= addItem('warning', 'Panel Database Connection Fail', 'Failed to connect to Database, with given error: <strong>' . $connection->connect_error . '</strong>. Try the X3 <a href="./panel/db_check.php" target="_blank">Database connection checker</a>.');
				}
			} else {
				# Check if is installed
				$query = 'SELECT * FROM `filemanager_db` ORDER BY `id` LIMIT 1';
				$result = $connection->query($query);

				if(!$result) {
					$warning .= addItem('warning', 'X3 Panel DB not installed', 'Although successfully connected to the database "' . $dbname . '", you do not seem to have installed the X3 database panel. Try the <a href="' . $link_path . '/panel/install/" target="_blank">X3 Panel Install</a> script.');
				} else {
					$fetch = $result->fetch_object();
					if(empty($fetch)) {
						$warning .= addItem('warning', 'X3 Panel DB not installed', 'Although successfully connected to the database "' . $dbname . '", you do not seem to have installed the X3 database panel. Try the <a href="' . $link_path . '/panel/install/" target="_blank">X3 Panel Install</a> script.');
					}
					$result->close();
				}

				# close connection
				$connection->close();
			}

		}

	# Check default panel login
	} else if(X3Config::$config["back"]["panel"]["username"] === "admin" && X3Config::$config["back"]["panel"]["password"] === "admin") {
		$warning .= addItem('warning', 'Default Panel Login', 'It seems you are using the default Panel login. Please go to <a href="' . $link_path . '/panel/" target="_blank">X3 Panel</a> &rsaquo; settings &rsaquo; panel, and change the username and password to secure your website.');
	}

	# Check that /config exists
	if(!file_exists($file_path.'/config')){
		$warning .= addItem('warning', 'Missing config Folder', 'Where is your root <code>config</code> folder? This folder should be in your X3 root, and is meant to contain your custom settings and folder passwords.');
	} else {

		# Make sure config is blocked
		if(!$config_blocked){

			# Check that config/.htaccess exists (apache only)
			if($server_is_like_apache){

				if(!file_exists($file_path.'/config/.htaccess') && file_exists($file_path.'/.htaccess') && $htaccess_allowed) {

					# Try to write '/config/.htaccess'
					$write_config_htaccess = false;
					if(is_writable($file_path.'/config') && file_exists('./app/resources/deny.htaccess')) {
						$write_config_htaccess = @copy('./app/resources/deny.htaccess', './config/.htaccess');
					}

					# If couldn't write file, add warning
					if(!$write_config_htaccess) $critical .= addItem('danger', 'Missing config/.htaccess File', 'Where is your <code>config/.htaccess</code> file? This file is necessary to protect your configuration settings from being visible public.');

				} else {
					$warning .= addItem('warning', 'Directory /config/ is visible', 'Your settings in the /config/ folder are visible from www. Deny access to this directory!');
				}

			# Config is not blocked (non-Apache)
			} else {
				$warning .= addItem('warning', 'Directory /config/ visible', 'Your settings in the /config/ folder are visible from www. Deny access to this directory!');
			}
		}

		# Check that config/ is writeable
		if(!is_writeable($file_path.'/config')) {
			$warning .= addItem('warning', 'Config folder is not writeable', 'Your root <code>config/</code> folder is not writeable. You need to set permissions on this folder so that the X3 panel can store user settings and folder-passwords here.');
		}
	}

	# Check for /PANEL
	if(!file_exists($file_path.'/panel')){
		$warning .= addItem('warning', 'Missing Panel', 'The <code>/panel/</code> admin folder seems to be missing. Did you intentionally rename it? <strong>Ok</strong>');
	}

	# Check preload vs content/site.json
	if(X3Config::$config["settings"]["preload"] === 'create' && !file_exists($file_path.'/content/site.json')){
		$warning .= addItem('warning', 'Missing Site Object', 'You have enabled the <strong>preload</strong> option, but you have not created the required <strong>site object</strong>. If you want to use the preload feature, you should go to <a href="' . $link_path . '/panel/" target="_blank">Panel</a> &rsaquo; tools &rsaquo; preload, and create site object.');
	}

	# Safe Mode
	if(ini_get('safe_mode')){
		$warning .= addItem('warning', 'PHP Safe Mode On', 'Your server is running <a href="http://php.net/manual/en/features.safe-mode.php" target="_blank">PHP Safe Mode</a>. This feature will most likely prevent the X3 <a href="' . $link_path . '/panel/" target="_blank">Admin Panel</a> from being able to save changes, and is therefore not supported. Safe Mode was deprecated as of PHP 5.3.0 and removed as of PHP 5.4.0.');
	}

	# Suhosin
	if(extension_loaded('suhosin')){
		$warning .= addItem('warning', 'Suhosin detected!', 'Your server seems to be running the <a href="http://suhosin.org/" target="_blank">Suhosin</a> PHP security extension. Depending on how Suhosin is configured on your server, it could prevent X3 from working properly. If you are lucky, it will behave nicely.');
	}

	# Server warnings, only if !mod_rewrite_confirmed
	if(!$mod_rewrite_confirmed){

		# Server string empty
		if(!$server_software){
			$warning .= addItem('warning', 'Unknown Server Software', 'Your server does not return the software it is running. We cannot diagnose this server and it is unknown if it will work with X3.');

		# Unsupported server software warning
		} else if(!in_array($server_software, $supported_servers)){
			$warning .= addItem('warning', $_SERVER['SERVER_SOFTWARE'], 'You are running server software not tested with X3, and we cannot guarantee that X3 will work properly. <a href="https://www.photo.gallery/contact/" target="_blank">Email us</a> with details about your specific server software, and we will look into it.');

		# NGINX warning
		} else if($server_software === 'nginx'){
			$warning .= addItem('warning', 'NGINX Server Detected', 'Your website is hosted on <a href="https://www.nginx.com/" target="_blank">NGINX</a> [' . $_SERVER['SERVER_SOFTWARE'] . '] web server. To get X3 working properly, you will need to add a few rules to your NGINX <a href="http://nginx.org/en/docs/beginners_guide.html" target="_blank">configuration file</a>.<br><br><strong><a href="https://gist.github.com/mjau-mjau/6dc1948284c90d167f51f1e566a8457b" target="_blank">[X3 NGINX Sample Config]</a></strong>');

		# Lighttpd warning
		} else if($server_software === 'lighttpd'){
			$warning .= addItem('warning', 'Lighttpd Server Detected', 'Your website is hosted on <a href="https://www.lighttpd.net/" target="_blank">Lighttpd</a> web server. To get X3 working properly, you will need to add a few rules to your Lighttpd <a href="https://redmine.lighttpd.net/projects/1/wiki/TutorialConfiguration" target="_blank">configuration file</a>. For more information, please <a href="https://www.photo.gallery/contact/" target="_blank">contact us</a>.<br><br><code>' . $_SERVER['SERVER_SOFTWARE'] . '</code>');

		# Caddy warning
		} else if($server_software === 'caddy'){
			$warning .= addItem('warning', 'Caddy Server Detected', 'Your website is hosted on <a href="https://caddyserver.com/" target="_blank">Caddy</a> web server. To get X3 working properly, you will need to add a few rules to your <a href="https://caddyserver.com/docs/caddyfile" target="_blank">Caddyfile</a>. For more information, please <a href="https://www.photo.gallery/contact/" target="_blank">contact us</a>.<br><br><code>' . $_SERVER['SERVER_SOFTWARE'] . '</code>');
		}
	}

	# Open basedir warning
	/*if($open_basedir){
		$warning .= addItem('warning', 'PHP open_basedir restriction', 'Your server seems to have PHP <a href="http://php.net/manual/en/ini.core.php#ini.open-basedir" target="_blank">open_basedir</a> restriction. X3 will still work, but it will not be able to flush expired html/php cache files. The open_basedir setting is primarily used to prevent PHP scripts from accessing files in another user\'s account ... Unfortunately, it also mistakingly prevents the X3 PHP script from deleting it\'s own html/php cache files.');
	}*/


	### EXTENDED ###

	if(isset($_GET["diagnostics"]) && (!isset($_SERVER['X3_HIDE_DIAGNOSTICS']) || $x3_diagnostics)) {

		# X3 Version
		if($x3_version) $info .= addInfo('X3 Version', ($x3_version_date ? '<span style="float:right; color: #AAA;">' . date('d M Y H:i:s', $x3_version_date/1000) . '</span>' : '') . $x3_version, true);

		# PHPinfo
		$info .= addInfo('PHP Version', phpversion(), phpversion() >= 5.3);

		# Safe Mode
		$safe_mode = ini_get('safe_mode');
		$info .= addInfo('Safe Mode', $safe_mode ? 'on' : 'off', !$safe_mode);

		# UTF-8
		$utf8 = function_exists('preg_match') && @preg_match('/^.$/u', 'ñ') && @preg_match('/^\pL$/u', 'ñ');
		$info .= addInfo('UTF-8 Support', $utf8 ? 'on' : 'off', $utf8);

		# php file uploads
		$file_uploads = checkPhpIniOn('file_uploads');
		$info .= addInfo('PHP File Uploads', $file_uploads ? 'on' : 'off', $file_uploads);

		# SMTP
		$smtp = strlen(ini_get('SMTP')) > 0;
		$info .= addInfo('SMTP', $smtp ? 'on' : 'off', $smtp);

		# htaccess AllowOverride
		if($server_is_like_apache && !$htaccess_allowed) $info .= addInfo('.htaccess <small>AllowOverride</small>', $htaccess_allowed ? 'All' : 'None', $htaccess_allowed ? true : false);

		# PHP EXTENSIONS
		$info .= infoHeader('PHP Extensions');

		# GD extension
		$gd_extension = extension_loaded('gd') && function_exists('gd_info');
		$info .= addInfo('GD Extension', $gd_extension ? 'on' : 'off', $gd_extension);

		# mysqli
		$mysqli_extension = function_exists('mysqli_connect');
		$info .= addInfo('Mysqli Extension', $mysqli_extension ? 'on' : 'off', $mysqli_extension);

		# mcrypt
		//$mcrypt_extension = extension_loaded('mcrypt');
		//$info .= addInfo('Mcrypt Extension', $mcrypt_extension ? 'on' : 'off', $mcrypt_extension);

		# openssl
		$openssl_extension = extension_loaded('openssl');
		$info .= addInfo('OpenSSL Extension', $openssl_extension ? 'on' : 'off', $openssl_extension);

		# iconv
		$iconv_extension = extension_loaded('iconv');
		$info .= addInfo('Iconv Extension', $iconv_extension ? 'on' : 'off', $iconv_extension);

		# mbstring
		$mbstring_extension = extension_loaded('mbstring');
		$info .= addInfo('Mbstring Extension', $mbstring_extension ? 'on' : 'off', $mbstring_extension);

		# exif
		$exif_extension = extension_loaded('exif');
		$info .= addInfo('Exif Extension', $exif_extension ? 'on' : 'off', $exif_extension);

		$xml_extension = extension_loaded('xml');
		$info .= addInfo('XML Extension', $xml_extension ? 'on' : 'off', $xml_extension);


		# MODS
		if($server_is_like_apache) $info .= infoHeader('Apache Mods');

		# Mod Rewrite
		$info .= addInfo('Rewrite', $has_mod_rewrite ? 'on' : 'undetectable', $has_mod_rewrite);

		# Various Apache modules
		if($server_is_like_apache) {

			$undetectable_val = $php_apache ? false : null;
			$undetectable_txt = $php_apache ? 'Undetectable' : 'Undetectable, but probably enabled.';

			# Mod Deflate
			$mod_deflate = hasApacheModule('mod_deflate');
			$info .= addInfo('Mod Deflate', $mod_deflate ? 'on' : $undetectable_txt, $mod_deflate ? true : $undetectable_val);

			# Mod Setenvif
			$mod_setenvif = hasApacheModule('mod_setenvif');
			$info .= addInfo('Mod Setenvif', $mod_setenvif ? 'on' : $undetectable_txt, $mod_setenvif ? true : $undetectable_val);

			# Mod Mime
			$mod_mime = hasApacheModule('mod_mime');
			$info .= addInfo('Mod Mime', $mod_mime ? 'on' : $undetectable_txt, $mod_mime ? true : $undetectable_val);

			# Mod Headers
			$mod_headers = hasApacheModule('mod_headers');
			$info .= addInfo('Mod Headers', $mod_headers ? 'on' : $undetectable_txt, $mod_headers ? true : $undetectable_val);

			# Mod auth basic / required for password protected pages // https://httpd.apache.org/docs/2.4/mod/mod_auth_basic.html
			$mod_auth_basic = hasApacheModule('mod_auth_basic');
			$info .= addInfo('Mod Auth Basic', $mod_auth_basic ? 'on' : $undetectable_txt, $mod_auth_basic ? true : $undetectable_val);

			# Mod Security
			$mod_security = hasApacheModule('mod_security');
			$info .= addInfo('Mod Security', $mod_security ? 'on' : 'off');
		}


		# VALUES
		$info .= infoHeader('Values');

		# server name
		$info .= addInfo('Server name', getServerEnv('SERVER_NAME'), getServerEnv('SERVER_NAME') !== 'undefined' ? '' : false);

		# Server Software
		$info .= addInfo('Server software', getServerEnv('SERVER_SOFTWARE'), getServerEnv('SERVER_SOFTWARE') !== 'undefined' ? '' : false);

		# PHP interface
		$info .= addInfo('PHP Interface', empty($php_interface) ? 'undetectable' : $php_interface);

		# memory limit
		$info .= addInfo('PHP Memory Limit', ini_get('memory_limit'), ini_get('memory_limit'));

		# dynamic memory assignment
		$memory_limit = ini_get('memory_limit');
		if(!empty($memory_limit) && intval($memory_limit) > 0){
			$memory_limit = intval($memory_limit);
			$new_memory_limit = ($memory_limit + 1) . 'M';
			$change_memory = ini_set('memory_limit', $new_memory_limit);
			$memory_was_changed = $change_memory && ini_get('memory_limit') === $new_memory_limit;
			$info .= addInfo('Dynamic Memory Limit', $memory_was_changed ? 'Yes' : 'No', !$memory_was_changed && $memory_limit < 32 ? false : 'neutral');
		}

		# php upload max file size
		$info .= addInfo('Upload Max File Size', ini_get('upload_max_filesize'), ini_get('upload_max_filesize'));

		# Max file uploads
		$info .= addInfo('Max File Uploads', ini_get('max_file_uploads'), ini_get('max_file_uploads'));

		# Post max size
		$info .= addInfo('Post Max Size', ini_get('post_max_size'), ini_get('post_max_size'));

		# Max input vars
		$info .= addInfo('Max Input Vars', ini_get('max_input_vars'), ini_get('max_input_vars'));

		# Time Zone
		$tz = ini_get('date.timezone');
		$info .= addInfo('Default Timezone', empty($tz) ? 'Not specified' : date_default_timezone_get(), empty($tz) ? false : 'neutral');

		# Open Basedir
		$info .= addInfo('Open Basedir', $open_basedir ? 'on <em style="float: right;">* should not be a problem</em>' : 'off', $open_basedir ? false : 'neutral');

		# session_save_path
		$info .= addInfo('Session Save Path', empty($session_save_path_original) ? '<em>empty</em>' : $session_save_path_original, $session_save_path_result);

		# session.cookie_lifetime
		$session_cookie_lifetime = @ini_get("session.cookie_lifetime");
		if($session_cookie_lifetime === '0' || !empty($session_cookie_lifetime)) $info .= addInfo('Session cookie lifetime', $session_cookie_lifetime, 'neutral');

		# session.gc_maxlifetime
		$session_gc_maxlifetime = @ini_get("session.gc_maxlifetime");
		if(!empty($session_gc_maxlifetime)) $info .= addInfo('Session maxlifetime', $session_gc_maxlifetime, 'neutral');

		# VARIABLES
		//$info .= infoHeader('Variables');

		# Server Name
		$info .= addInfo('SERVER_NAME', getServerEnv('SERVER_NAME'), getServerEnv('SERVER_NAME') !== 'undefined' ? '' : false);

		# Document Root
		//$info .= addInfo('DOCUMENT_ROOT', getServerEnv('DOCUMENT_ROOT'), getServerEnv('DOCUMENT_ROOT') !== 'undefined' ? '' : false);

		# Script Name
		//$info .= addInfo('SCRIPT_NAME', getServerEnv('SCRIPT_NAME'), getServerEnv('SCRIPT_NAME') !== 'undefined' ? '' : false);

		# Script Filename
		//$info .= addInfo('SCRIPT_FILENAME', getServerEnv('SCRIPT_FILENAME'), getServerEnv('SCRIPT_FILENAME') !== 'undefined' ? '' : false);

		# Server Software
		$info .= addInfo('SERVER_SOFTWARE', getServerEnv('SERVER_SOFTWARE'), getServerEnv('SERVER_SOFTWARE') !== 'undefined' ? '' : false);

	}



	### OUTPUT ###

	if(!empty($critical)) $output .= "<h2>Critical Issues</h2>".$critical;
	if(!empty($warning)) $output .= "<h2>Warnings</h2>".$warning;

	# OK!
	if(empty($output)) {
		$output .= addItem('success', 'Everything seems to be OK!', ($x3_diagnostics ? 'Go to your <a href="' . $link_path . '/panel/" target="_blank">Panel</a> &rsaquo; Settings &rsaquo; Advanced and disable "Show Diagnostics".' : 'Nothing to report here.')). $success;

	# Only warnings
	} else if(empty($critical)){
		$output = addItem('success', 'Server OK', 'There are no critical issues, but we recommend resolving the warnings below if possible.' . ($x3_diagnostics ? ' Once satisfied, you may proceed to <a href="' . $link_path . '/panel/" target="_blank">Panel</a> &rsaquo; Settings &rsaquo; Advanced and disable "Show Diagnostics".' : '')) . $success . $output;

	# Only Critical
	} else if(empty($warning)){
		$output = addItem('neutral', null, ($x3_diagnostics ? 'Once critical issues are resolved, proceed to <a href="' . $link_path . '/panel/" target="_blank">Panel</a> &rsaquo; Settings &rsaquo; Advanced to disable diagnostics.' : 'Resolve critical issues below.')). $success . $output;

	# Both Critical and Warnings
	} else {
		$output = addItem('neutral', null, ($x3_diagnostics ? 'Once critical issues are resolved, proceed to <a href="' . $link_path . '/panel/" target="_blank">Panel</a> &rsaquo; Settings &rsaquo; Advanced to disable diagnostics.' : 'Resolve critical issues below.')). $success . $output;
	}

	# Extended diagnostics
	if(!empty($info)) $output .= '<h2>Extended Diagnostics</h2><table class="info">' . $info . '</table>';

	echo $output;

// !POST
} else { ?>
<html>
<head>
<title>X3 Diagnostics</title>
<meta name="robots" content="noindex, nofollow">
<link href="<?php echo ABSOLUTE ?>/app/public/css/diagnostics.css<?php echo $x3_buster; ?>" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="x3-diagnostics">
		<h1>X3 Diagnostics<?php echo $x3_version ? " <small>X".$x3_version."</small>" : ""; ?></h1>
		<div class="x3-diagnostics-wrapper"><h2 style='margin-top: 3em;'>Loading ...</h2></div>
	</div>
<script>
var r = new XMLHttpRequest();
r.onreadystatechange = function(data) {
	if(r.readyState == 4 && r.status == 200) document.getElementsByClassName('x3-diagnostics-wrapper')[0].innerHTML = r.responseText;
}
r.open('POST', location.href);
r.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
r.send('get-x3-diagnostics=true');
var head = document.getElementsByTagName('head')[0];
var link  = document.createElement('link');
link.rel  = 'stylesheet';
link.type = 'text/css';
link.href = 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600';
link.media = 'all';
head.appendChild(link);
</script>
</body>
</html>
<?php } ?>