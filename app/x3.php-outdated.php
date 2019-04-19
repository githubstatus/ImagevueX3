<?php
if(version_compare(PHP_VERSION, '5.3.0', '>=')) exit();
$self = $_SERVER['PHP_SELF'];
$css_path = basename($self) === 'index.php' ? dirname($self) : dirname(dirname($self));
if(substr($css_path, -1) !== '/') $css_path .= '/';
?>
<html>
<head>
<title>Outdated PHP</title>
<meta name="robots" content="noindex, nofollow">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600" rel="stylesheet">
<link href="<?php echo $css_path ?>app/public/css/diagnostics.css?v=3.25.0" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="x3-diagnostics">
		<h1>Outdated PHP</h1>
		<div class="x3-diagnostics-wrapper">
			<div class="x3-diagnostics-item x3-diagnostics-danger"><strong>Outdated PHP version <?php echo PHP_VERSION; ?></strong><div class="x3-diagnostics-description">Your server is running an outdated <strong>PHP version <?php echo PHP_VERSION; ?></strong>.<br><br>X3 requires <strong>PHP 5.3.0 or higher</strong> to work properly. You should check from your hosting control panel if you can upgrade the PHP version, or you will need to contact your host. <a href="https://secure.php.net/releases/">[PHP Releases]</a></div></div>
		</div>
	</div>
</body>
</html>