<?php

/* DON'T EDIT THIS FILE! */

// Get config
require_once dirname(__DIR__) . "/app/x3.config.inc.php";
X3Config::$config["x3_version"] = '3.27.6';
X3Config::$config["x3_version_date"] = 1551789126985;
X3Config::$config["x3_panel_version"] = '3.27.6';
$x3_panel_config = X3Config::$config["back"]["panel"];
$x3_mail = X3Config::$config["back"]["mail"];


// X3 Panel configuration

// Optional Overwrite constants from ../../x3_panel_config.php if file exists
// error_reporting(E_ALL & ~E_NOTICE);
// if(file_exists('../../x3_panel_config.php')) include '../../x3_panel_config.php';

// database login
if($x3_panel_config["use_db"]) {

	define("DB_HOST", $x3_panel_config["db_host"]); // Host address of mysql server
	define("DB_USER", $x3_panel_config["db_user"]); // Username of your mysql server
	define("DB_PASS", $x3_panel_config["db_pass"]); // Password of your user on mysql server
	define("DB_NAME", $x3_panel_config["db_name"]); // The database name that you created on your mysql server

// Non-database main admin login
} else {
	define("SECRET_KEY", "mySecretKey");
	define("USERNAME", $x3_panel_config["username"]);
	define("PASSWORD", md5($x3_panel_config["password"]));
	define("FIRSTNAME", $x3_panel_config["first_name"]);
	define("LASTNAME", $x3_panel_config["last_name"]);
	define("EMAIL", $x3_panel_config["email"]);
	define("ID", 1);
}

// Additional users for non-DB version. Don't mess around with this unless you know what you are doing!
global $users;
/*$users = array(
  "username1" => array(
    "password" => md5("password1"),
    "email" => "user1@domain.com",
    "firstname" => "Bob",
    "lastname" => "Dobalina",
    "permissions" => array("create_folder","rename_folder","copy_folders","move_folders","remove_folders","upload_folders","edit_files","unzip_files", "zip_folders" ),
    "limitation" => 0,
    "dir_path" => "../content/",
    "is_block" => 0
  ),
  "username2" => array(
    "password" => md5("password2"),
    "email" => "user2@domain.com",
    "firstname" => "mjau",
    "lastname" => "mjau",
    "permissions" => array(),
    "limitation" => 0,
    "dir_path" => "../content/",
    "is_block" => 0
  )
);*/

// Default Language
define("DEFAULT_LNG", "English");

// SMTP Settings (not required)
define("IS_SMTP_USE", $x3_mail["use_smtp"]);
define("SMTPAuth", $x3_mail["SMTPAuth"]);
define("SMTPSecure", $x3_mail["SMTPSecure"]);
define("SMTPHost", $x3_mail["host"]);
define("SMTPPort", $x3_mail["port"]);
define("SMTPUsername", $x3_mail["username"]);
define("SMTPPassword", $x3_mail["password"]);
define("SMTPFromSMTPUsername", !empty($x3_mail["from"]));
define("SMTPFrom", $x3_mail["from"]);

// Image upload resizer defaults
define("IMG_RESIZE", $x3_panel_config["upload_resize"]["enabled"]);
define("IMG_RESIZE_WIDTH", $x3_panel_config["upload_resize"]["width"]);
define("IMG_RESIZE_HEIGHT", $x3_panel_config["upload_resize"]["height"]);
define("IMG_RESIZE_QUALITY", $x3_panel_config["upload_resize"]["quality"]);

// Cloudflare API
define("CLOUDFLARE_ENABLED", $x3_panel_config["cloudflare_enabled"]);
define("CLOUDFLARE_EMAIL", $x3_panel_config["cloudflare_email"]);
define("CLOUDFLARE_KEY", $x3_panel_config["cloudflare_key"]);

// Root directory path
define("ROOT_DIR_NAME", "../content");

// Allow Extensions
global $ALLOW_EXTENSIONS;
$ALLOW_EXTENSIONS = array('rar','zip','txt','html','pdf','jpg','jpeg','png','gif','bmp','psd','flv','mp3','ogg','mp4','svg', 'webp', 'js', 'css', 'gpx', 'eot', 'ttf', 'woff', 'woff2', 'otf', 'xml');

// Allow Uploader Extensions
global $ALLOW_UPLOADER;
$ALLOW_UPLOADER = array('rar','zip','txt','html','pdf','jpg','jpeg','png','gif','bmp','psd','flv','mp3','ogg','mp4','svg', 'webp', 'js', 'css', 'gpx', 'eot', 'ttf', 'woff', 'woff2', 'otf', 'xml');

// Mime type of upload extensions
global $MIME_TYPES;
$MIME_TYPES = array(
    "jpg" => array("image/jpeg", "image/pjpeg", "application/octet-stream"),
    "jpeg" => array("image/jpeg", "image/pjpeg", "application/octet-stream"),
    "bmp" => array("image/bmp", "application/octet-stream"),
    "gif" => array("image/gif", "application/octet-stream"),
    "webp" => array("image/webp", "application/octet-stream"),
    "pdf" => array("application/pdf", "application/zip", "application/octet-stream"),
    "zip" => array("application/zip", "application/octet-stream", "application/download"),
    "rar" => array("application/x-rar-compressed", "application/octet-stream", "application/download", "application/x-rar"),
    "doc" => array("application/msword", "text/html", "application/octet-stream"),
    "docx" => array("application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/zip", "application/octet-stream"),
    "xls" => array("application/vnd.ms-excel", "text/html", "application/octet-stream"),
    "xlsx" => array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/zip", "application/octet-stream"),
    "ppt" => array("application/vnd.ms-powerpoint", "text/html", "application/vnd.ms-office", "application/octet-stream"),
    "pptx" => array("application/vnd.openxmlformats-officedocument.presentationml.presentation", "application/zip", "application/octet-stream"),
    "psd" => array("image/photoshop", "image/x-photoshop", "image/psd", "application/photoshop", "application/psd", "zz-application/zz-winassoc-psd", "application/octet-stream"),
    "flv" => array("video/x-flv", "application/octet-stream"),
    "mp3" => array("audio/mpeg", "audio/mp3", "audio/mpeg3", "audio/x-mpeg-3", "video/mpeg", "video/x-mpeg", "application/octet-stream", "video/mp4"),
    "ogg" => array("application/ogg"),
    "mp4" => array("video/mp4v-es", "audio/mp4", "application/octet-stream", "video/mp4"),
    "wav" => array("audio/wav", "audio/x-wav", "audio/wave", "audio/x-pn-wav", "application/octet-stream"),
    "mov" => array("video/quicktime", "video/x-quicktime", "image/mov", "audio/aiff", "audio/x-midi", "audio/x-wav", "video/avi", "application/octet-stream"),
    "avi" => array("video/avi", "video/msvideo", "video/x-msvideo", "image/avi", "video/xmpg2", "application/x-troff-msvideo", "audio/aiff", "audio/avi", "application/octet-stream"),
    "js" => array("application/javascript"),
    "css" => array("text/css"),
    "gpx" => array("application/gpx", "application/gpx+xml", "application/xml"),
    "xml" => array("text/xml", "application/xml")
);

// Hide AUTH page.
// define("HIDE_AUTH", true);

// Thank you and goodbye!

?>