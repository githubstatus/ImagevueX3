<?php
if (!isset($core))
{
	require_once 'filemanager_core.php';
	$core = new filemanager_core();
    require_once 'filemanager_language.php';
}
if ($core->isLogin())
{
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="<?php echo $language["charset"];?>">
        <title><?php echo $language["title"];?></title>
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php # favicon
	      $favicon = $core->first_image('../content/custom/favicon');
	      if($favicon) echo '<link rel="icon" href="../content/custom/favicon/' . $favicon . '">';
	      ?>

        <!-- Critical CSS Stylesheets -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/simplemde@1.11.2/dist/simplemde.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Montserrat:500|Source+Sans+Pro:400,400i,600,600i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <link href="filemanager_css/x3.panel.css?v=<?php echo X3Config::$config["x3_panel_version"]; ?>" rel="stylesheet" />

        <?php
        if(!$core->is_basedir() && !isset($_SESSION['filemanager_super'])){
            // load custom panel.css from parent + parent-parent of X3 installation if exists
    	   if(file_exists('../../panel.css')) echo '<style><!--' . file_get_contents('../../panel.css') . '--></style>';
    	   if(file_exists('../../../panel.css')) echo '<style><!--' . file_get_contents('../../../panel.css') . '--></style>';
        }
    	// load custom custom.css from panel folder if exists
    	if(file_exists('custom.css')) echo '<style><!--' . file_get_contents('custom.css') . '--></style>';
    	// load /config/panel.css if exists
    	if(file_exists('../config/panel.css')) echo '<style><!--' . file_get_contents('../config/panel.css') . '--></style>';
        ?>

        <style>
            body {
                direction: <?php echo $language["direction"];?>;
            }
        </style>
    </head>
<?php 
}
else
{
	header("Location: .");
}
?>
