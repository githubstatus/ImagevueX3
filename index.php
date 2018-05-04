<?php

$time_pre = microtime(true);

# Global paths
class Config {
  public static $root_folder = './';
  public static $app_folder = './app';
  public static $content_folder = './content';
  public static $templates_folder = './app/twig';
  public static $cache_folder = './_cache';
}

# Includes
include './app/cache.inc.php';
include './app/helpers.inc.php';
include './app/stacey.inc.php';
include './app/x3.config.inc.php';
include './app/asset-types/page.inc.php';

# Show X3 Diagnostics?
if(X3Config::$config["settings"]["diagnostics"] || isset($_GET["diagnostics"])) {
	$show_x3_diagnostics = true;
	require_once './app/x3.diagnostics.php';

# Start X3 App
} else {
	new Stacey($_GET);
}

?>
