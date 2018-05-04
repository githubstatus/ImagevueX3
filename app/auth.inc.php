<?php

Class BasicAuth {

	static $username = '';
  static $password = '';

  function __construct($username, $password, $users, $type) {

  	// Create response depending on $type: JSON or HTML
  	$response = ((string)$type == 'json') ? '{"content":"<div class=\"not-authorized\"><i class=\"fa fa-ban\"></i></div>"}' : 'Not Authorized.';
  	$content = ((string)$type == 'json') ? 'Content-Type: application/json' : 'Content-Type:text/html';

  	// Fix in case _USER and _PW always return empty
  	if(!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW'])){
  		if(!empty($_SERVER['HTTP_AUTHORIZATION'])) {
  			$d = $_SERVER['HTTP_AUTHORIZATION'];
  		} else if(!empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
  			$d = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
  		} else if(!empty($_SERVER['REDIRECT_REMOTE_USER'])) {
  			$d = $_SERVER['REDIRECT_REMOTE_USER'];
  		}
  		if(!empty($d)) list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', base64_decode(substr($d, 6)));
  	}

  	// Get x3_users from config/protect.php
  	global $protect_ob;
    $x3_users = $protect_ob["users"];

    // check
    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || 

    	((empty($x3_users) || empty($users) || !in_array($_SERVER['PHP_AUTH_USER'], $users) || empty($x3_users[$_SERVER['PHP_AUTH_USER']]) || $x3_users[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW']) && 

    		(substr($_SERVER['PHP_AUTH_USER'], -1) != "*" || empty($x3_users[$_SERVER['PHP_AUTH_USER']]) || $x3_users[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW']) &&

    		(empty($password) || $_SERVER['PHP_AUTH_PW'] != $password || (!empty($username) && $_SERVER['PHP_AUTH_USER'] != $username)))) {
      header('WWW-Authenticate: Basic realm="Private area."');
      header('HTTP/1.0 401 Unauthorized');

      // Cancel text
      header($content);
      echo $response;
      exit;
    }

  }

}

?>
