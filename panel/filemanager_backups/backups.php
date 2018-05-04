<?php
if (!isset($core))
{
	require_once '../filemanager_core.php';
	$core = new filemanager_core();
}
if ($core->isLogin())
{
	if (isset($_GET["file_name"]))
	{
		if (file_exists($_GET["file_name"]))
		{
			 header('Content-Description: File Transfer');
		     header('Content-Type: application/octet-stream');
		     header('Content-Disposition: attachment; filename='.basename($_GET["file_name"]));
		     header('Content-Transfer-Encoding: binary');
		     header('Expires: 0');
		     header('Cache-Control: must-revalidate');
		     header('Pragma: public');
		     header('Content-Length: ' . filesize($_GET["file_name"]));
		     @ob_clean();
		     flush();
		     readfile($_GET["file_name"]);
    		 exit;
		}
		else
		{
			header("Status: 404 Not Found");
		}
	}
	else 
	{
		header("Status: 404 Not Found");
	}
}
else 
{
	header("Status: 404 Not Found");
}
?>