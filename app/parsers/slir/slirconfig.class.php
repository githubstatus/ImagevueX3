<?php

// X3 image resizer config
// Built on SLIR (Smart Lencioni Image Resizer) https://github.com/lencioni/SLIR

// SLIR resizer config
class SLIRConfig {

	public static $browserCacheTTL = 315360000; // 10 years = 365 * 24 * 60 * 60 * 10
	public static $useRequestCache = TRUE;
	public static $copyEXIF	= FALSE;
	public static $maxMemoryToAllocate = 100;
	public static $defaultQuality	= 90;
	public static $defaultCropper	= SLIR::CROP_CLASS_CENTERED;
	public static $defaultProgressiveJPEG	= TRUE;
	public static $logErrors = TRUE;
	public static $errorImages = TRUE;
	public static $documentRoot	= '../../..';
	public static $SLIRDir = 'render';
	//public static $cacheDirName	= '/cache';
	public static $cacheDir	= '../../../_cache/images';
	public static $errorLogPath	= NULL;
	public static $forceQueryString	= FALSE;
	public static $garbageCollectProbability = 1;
	public static $garbageCollectDivisor = 500;
	public static $garbageCollectFileCacheMaxLifetime	= 2419200; // 28 days = 28 * 24 * 60 * 60

	// X3 resizer vars
  public static $allocateMemory = true; // Try to allocate more memory than default assigned memory from php.ini.
  public static $alwaysMaxMemory = true; // Always assign $maxMemoryToAllocate instead of estimating.
  public static $memoryFudge = 1; // Multiplier factor for auto memory estimation, if $alwaysMaxMemory = false.
  public static $copyICCProfile = false; // Copy ICC color profile into resized images. Disabled by default, as it slows down the resize.

  // init additional config vars
	public static function init(){

		// user config
		$user_config_file = '../../../config/config.user.json';
		if(file_exists($user_config_file) && is_readable($user_config_file)){
			$user_config_contents = file_get_contents($user_config_file);
			if(!empty($user_config_contents)) {
				$user_config = json_decode($user_config_contents, TRUE);
				if(!empty($user_config)){

					// default quality
					if(isset($user_config["back"]["image_resizer"]["default_quality"]) && 
						!empty($user_config["back"]["image_resizer"]["default_quality"]) && 
						is_numeric($user_config["back"]["image_resizer"]["default_quality"])) self::$defaultQuality = $user_config["back"]["image_resizer"]["default_quality"];

					// copy ICC color profile
					if(isset($user_config["back"]["image_resizer"]["copy_icc_profile"]) && 
						is_bool($user_config["back"]["image_resizer"]["copy_icc_profile"])) self::$copyICCProfile = $user_config["back"]["image_resizer"]["copy_icc_profile"];

					// use request cache
					if(isset($user_config["back"]["image_resizer"]["use_request_cache"]) && 
						is_bool($user_config["back"]["image_resizer"]["use_request_cache"])) self::$useRequestCache = $user_config["back"]["image_resizer"]["use_request_cache"];
				}
			}
		}

		// ALWAYS Disable request cache on IIS because of symlink permission issues
		if(stripos($_SERVER['SERVER_SOFTWARE'], 'iis') !== false) self::$useRequestCache = FALSE;

		// Define error log path
    self::$errorLogPath = __DIR__ . '/slir-error-log';
	}
}

// Init X3 SLIR config
SLIRConfig::init();
