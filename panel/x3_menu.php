<?php

// require xmlhttprequest POST
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
	&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' 
	&& $_SERVER["REQUEST_METHOD"] == 'POST' 
	){

	// vars
	$super = isset($_POST['user']) && $_POST['user'] == 'user' ? false : true;
	$default = $super ? '../content/*' : '../../content/*';
	$dir = isset($_POST['dir']) ? $_POST['dir'] . '*' : $default;
	$parent_max = $super ? 1 : 2;

	// exit for various conditions
	if(!$dir || strpos($dir, '../content') === false || substr_count($dir, '../') > $parent_max) exit();

	// get X3 class
	require 'X3.php';

	// chdir for sub users
	if(!$super) chdir('filemanager_user');

	// echo panel menu
	X3::get_folders();
	echo X3::make_dir_tree($dir);

	// lazy merge folders.json // only intersect if root is content
	if(!filter_var($_POST['is_guest'], FILTER_VALIDATE_BOOLEAN)) X3::merge_folders(X3::$data, $dir === $default);
}

?>