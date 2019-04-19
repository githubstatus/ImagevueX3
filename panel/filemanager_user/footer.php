<?php
if (!isset($core)){
	require_once '../filemanager_user_core.php';
	$core = new filemanager_user_core();
	$core->userInfo();
	$core->create_user_panel($core->user_id);
	require_once '../filemanager_language_user.php';
}
if ($core->isLogin() and $core->is_block == 0 and $core->role == "user"){
?>
</div> <!-- /container -->
<div class="footer">
	<div class="footer-inner">
		<i class="fa fa-chevron-up x3-scroll-up"></i>
		<span class="x3-version">X<?php echo X3Config::$config["x3_version"] ?></span>
	</div>
</div>

<!-- Javascript -->
<script src="https://cdn.jsdelivr.net/npm/blueimp-tmpl@3.11.0/js/tmpl.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/keymaster@1.6.2/keymaster.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/autosize@4.0.0/dist/autosize.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/scrolltofixed@1.0.6/jquery-scrolltofixed.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/blueimp-load-image@2.17.0/js/load-image.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/blueimp-canvas-to-blob@3.14.0/js/canvas-to-blob.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-ui@1.12.1/ui/widget.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/blueimp-file-upload@9.19.0/js/jquery.fileupload.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/blueimp-file-upload@9.19.0/js/jquery.fileupload-process.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/blueimp-file-upload@9.19.0/js/jquery.fileupload-image.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/blueimp-file-upload@9.19.0/js/jquery.fileupload-audio.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/blueimp-file-upload@9.19.0/js/jquery.fileupload-video.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/blueimp-file-upload@9.19.0/js/jquery.fileupload-validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/blueimp-file-upload@9.19.0/js/jquery.fileupload-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simplemde@1.11.2/dist/simplemde.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/underscore@1.8.3/underscore.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js"></script>
<script src="https://cdn.jsdelivr.net/npm/velocity-animate@1.0.0/velocity.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/velocity-animate@1.0.0/velocity.ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/photoswipe@4.1.2/dist/photoswipe.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/photoswipe@4.1.2/dist/photoswipe-ui-default.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.7.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/selectize@0.12.4/dist/js/standalone/selectize.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-hoverintent@1.8.2/jquery.hoverIntent.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-contextmenu@1.0.0/bootstrap-contextmenu.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-growl-ifightcrime@1.1.0/jquery.bootstrap-growl.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/z-schema@3.18.3/dist/ZSchema-browser-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.31.0/lib/codemirror.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/codemirror@5.31.0/mode/xml/xml.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.8/dist/summernote.min.js"></script>
<?php
$summernote_lang = false;
$language_array = array(
	'German'=>'de-DE',
	'French'=>'fr-FR',
	'Polish'=>'pl-PL',
	'Chinese'=>'zh-CN',
	'ar'=>'ar-AR',
	'bg'=>'bg-BG',
	'ca'=>'ca-ES',
	'cs'=>'cs-CZ',
	'da'=>'da-DK',
	'de'=>'de-DE',
	'el'=>'el-GR',
	'es'=>'es-ES',
	'fi'=>'fi-FI',
	'fr'=>'fr-FR',
	'he'=>'he-IL',
	'hr'=>'hr-HR',
	'hu'=>'hu-HU',
	'id'=>'id-ID',
	'it'=>'it-IT',
	'ja'=>'ja-JP',
	'ko'=>'ko-KR',
	'nb'=>'nb-NO',
	'nn'=>'nb-NO',
	'no'=>'nb-NO',
	'nl'=>'nl-NL',
	'pl'=>'pl-PL',
	'pt'=>'pt-PT',
	'ro'=>'ro-RO',
	'ru'=>'ru-RU',
	'sv'=>'sv-SE',
	'th'=>'th-TH',
	'tr'=>'tr-TR',
	'uk'=>'uk-UA',
	'vi'=>'vi-VN',
	'zh'=>'zh-CN'
);
$language_key = $lng === 'English' ? substr(strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']), 0, 2) : $lng;
if(array_key_exists($language_key, $language_array)) {
	$summernote_lang = $language_array[$language_key];
	echo '<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.8/lang/summernote-' . $summernote_lang . '.js"></script>';
}
?>

<!-- non-critical CSS -->
<link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/photoswipe@4.1.2/dist/photoswipe.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/photoswipe@4.1.2/dist/default-skin/default-skin.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/blueimp-file-upload@9.19.0/css/jquery.fileupload.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/blueimp-file-upload@9.19.0/css/jquery.fileupload-ui.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/selectize@0.12.4/dist/css/selectize.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/selectize@0.12.4/dist/css/selectize.bootstrap3.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.8/dist/summernote.css" rel="stylesheet" />

<!-- X3 vars -->
<?php
$server_software = $_SERVER['SERVER_SOFTWARE'];
if(stripos($server_software, 'apache') !== false || stripos($server_software, 'litespeed') !== false){
	$conf_editor = file_exists('../.htaccess') && !isset($_SERVER['X3_SERVER_CONFIG']) ? "'htaccess'" : "false";
} else if(stripos($server_software, 'iis') !== false){
	$conf_editor = file_exists('../web.config') ? "'web.config'" : "false";
} else {
	$conf_editor = "false";
}
$session_maxlifetime = @ini_get("session.gc_maxlifetime");
?>
<script>
var fileTreeUserFolder = '';
var cloudflare = <?php if(defined('CLOUDFLARE_ENABLED') && CLOUDFLARE_ENABLED && defined('CLOUDFLARE_EMAIL') && CLOUDFLARE_EMAIL && defined('CLOUDFLARE_KEY') && CLOUDFLARE_KEY) { echo 'true'; } else { echo 'false'; } ?>;
var custom_setting_templates = <?php echo (file_exists('../config/custom-setting-templates.json') && is_readable('../config/custom-setting-templates.json') ? 'true' : 'false') ?>;
var user = 'user';
var hide_auth = <?php if(defined('HIDE_AUTH') && HIDE_AUTH) { echo 'true'; } else { echo 'false'; } ?>;
var x3_version = '<?php echo X3Config::$config["x3_version"] ?>';
var x3_panel_version = '<?php echo X3Config::$config["x3_panel_version"] ?>';
var server_software = '<?php echo $server_software ?>';
var conf_editor = <?php echo $conf_editor; ?>;
var core_user_id = <?php echo $core->user_id; ?>;
var core_user_dir = '<?php echo $core->user_dir; ?>';
var session_maxlifetime = <?php echo !empty($session_maxlifetime) ? $session_maxlifetime : 'false'; ?>;
var summernote_lang = <?php echo $summernote_lang ? "'" . $summernote_lang . "'" : 'false'; ?>;
var userx = '<?php echo X3Config::$config["userx"] ?>';
var is_guest = false;

// get folders
var folders = <?php echo X3::get_folders(false); ?>;

reload_sidebar = false;
first_flag = true;
here = '';

// language object
var language = <?php echo json_encode($language); ?>;
var selected_lang = '<?php echo $lng; ?>';
</script>

<!-- X3 Panel versioned -->
<script src="filemanager_js/x3_panel.js?v=<?php echo X3Config::$config["x3_panel_version"]; ?>"></script>

<!-- init -->
<script>

function initShowFileManager(){
<?php
$key = "redirect_to_url_file_manager_go";
if(isset($_SESSION[$key])){
  $dir = $_SESSION[$key];
  unset($_SESSION[$key]);
	if(is_dir($dir)) {
?>
loading_from_file = false;
showFileManager('<?php echo addslashes($dir);?>');
<?php } else { ?>
loading_from_file = false;
showFileManager('');
<?php
}
} else {
?>
loading_from_file = false;
x3NavPage();
<?php } ?>
}

show_left_folder_menu();
</script>

</body>
</html>

<?php
} else {
	header("Location: .");
}
?>
