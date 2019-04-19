<?php

// FROM https://github.com/jamesryanbell/cloudflare

// get filemanager core
if(!isset($core)){
	require_once 'filemanager_core.php';
	$core = new filemanager_core();
}

// error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Get method
function get($path, $data = array()) {
	return request($path, $data, 'get', 'read');
}

// Post method
function post($path, $data = array()) {
	return request($path, $data, 'post', 'edit');
}

// Put method
function put($path, $data = array()) {
	return request($path, $data, 'put', 'edit');
}

// Delete method
function delete($path, $data = array()) {
	return request($path, $data, 'delete', 'edit');
}

// Patch method
function patch($path, $data = array()) {
	return request($path, $data, 'patch', 'edit');
}

function request($path, $data = array(), $method = 'get', $permission_level = 'read') {
	$cf_email = CLOUDFLARE_EMAIL;
	$cf_key = CLOUDFLARE_KEY;

	// Make sure auth is set
	if(!isset($cf_email) || !isset($cf_key)) {
		throw new Exception('Authentication information must be provided');
		return false;
	}

	//Removes null entries
	$data = array_filter($data, function($val) {
		return !is_null($val);
	});

	$url = 'https://api.cloudflare.com/client/v4/' . $path;

	$default_curl_options = array(
		CURLOPT_VERBOSE        => false,
		CURLOPT_FORBID_REUSE   => true,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_HEADER         => false,
		CURLOPT_TIMEOUT        => 5,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_FOLLOWLOCATION => true
	);

	$curl_options = $default_curl_options;

	//$headers = array("X-Auth-Email: {$cf_email}", "X-Auth-Key: {$cf_key}");
	$cf_agent = 'ImagevueX3/' . X3Config::$config["x3_version"];
	$headers = array("X-Auth-Email: {$cf_email}", "X-Auth-Key: {$cf_key}", "User-Agent: {$cf_agent}");

	$ch = curl_init();

	curl_setopt_array($ch, $curl_options);

	if( $method === 'post' ) {
		curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	} else if ( $method === 'put' ) {
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PUT'));
	} else if ( $method === 'delete' ) {
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$headers[] = "Content-type: application/json";
	} else if ($method === 'patch') {
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		$headers[] = "Content-type: application/json";
	} else {
		$url .= '?' . http_build_query($data);
	}

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_URL, $url);

	$http_result = curl_exec($ch);
	$error       = curl_error($ch);
	$information = curl_getinfo($ch);
	$http_code   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	curl_close($ch);
	if ($http_code != 200) {
		return array(
			'error'       => $error,
			'http_code'   => $http_code,
			'method'      => $method,
			'result'      => $http_result,
			'information' => $information
		);
	} else {
		return json_decode($http_result);
	}
}

// Get zones data
function zones($name = '', $status = 'active', $page = 1, $per_page = 20, $order = 'status', $direction = 'desc', $match = 'all') {
	$data = array(
		'name'      => $name,
		'status'    => $status,
		'page'      => $page,
		'per_page'  => $per_page,
		'order'     => $order,
		'direction' => $direction,
		'match'     => $match
	);
	return get('zones', $data);
}

// Get Zone details
function zone($zone_identifier) {
	return get('zones/' . $zone_identifier);
}

// Pause Zone
function pause($zone_identifier) {
	return put('zones/' . $zone_identifier . '/pause');
}

// Unpause Zone
function unpause($zone_identifier) {
	return put('zones/' . $zone_identifier . '/unpause');
}

// Add DNS 
function addDns($zone_identifier, $type, $name, $content, $ttl = 1) {
	$data = array(
		'type'    => strtoupper($type),
		'name'    => $name,
		'content' => $content,
		'ttl'     => $ttl
	);
	return post('zones/' . $zone_identifier . '/dns_records', $data);
}

// List DNS
function list_records($zone_identifier, $type = 'A', $name = null, $content = null, $vanity_name_server_record = null, $page = 1, $per_page = 20, $order = '', $direction = 'desc', $match = 'all') {
	$data = array(
		'type'                      => $type,
		'name'                      => $name,
		'content'                   => $content,
		'vanity_name_server_record' => $vanity_name_server_record,
		'page'                      => $page,
		'per_page'                  => $per_page,
		'order'                     => $order,
		'direction'                 => $direction,
		'match'                     => $match
	);
	return get('zones/' . $zone_identifier . '/dns_records', $data);
}

// Get DNS item
function getDNS($zone_identifier, $identifier) {
	return get('zones/' . $zone_identifier . '/dns_records/' . $identifier);
}

// Purge ALL
function purge($identifier, $purge_everything = true) {
	$data = array(
		'purge_everything' => $purge_everything
	);
	return delete('zones/' . $identifier . '/purge_cache', $data);
}

// Purge files
function purge_files($identifier, array $files) {
	$data = array(
		'files' => $files
	);
	return delete('zones/' . $identifier . '/purge_cache', $data);
}

// Get Settings
function get_settings($zone_identifier) {
	return get('zones/' . $zone_identifier . '/settings');
}

// Toggle devmode
function change_development_mode($zone_identifier, $value = 'off') {
	$data = array('value' => $value);
	return patch('zones/' . $zone_identifier . '/settings/development_mode', $data);
}

// Set Rocket loader
function change_rocket_loader($zone_identifier, $value = 'off') {
	return patch('zones/' . $zone_identifier . '/settings/rocket_loader', $value);
}

// Change SSL
function change_ssl($zone_identifier, $value = 'off') {
	return patch('zones/' . $zone_identifier . '/settings/ssl', $value);
}

//$data = array('name' => 'flamepix.com');
//$identifier = '27f693861a5350e1b0833cee368d038b'; // (flamepix ID)
//$response = zones('flamepix.com'); // GET ID
//$files = ['https://flamepix.com/public/css/0.9/x3.skin.white.css','https://flamepix.com/public/css/0.9/x3.skin.black.css'];
//$response = purge_files($identifier, $files);
//$response = zones('flamepix.com');

function cloudflare() {
	if(isset($_POST['action'])) {
		$a = $_POST['action'];
		if(isset($_POST['zone_identifier'])) $zid = $_POST['zone_identifier'];
		if($a == 'zones') {
			//return zones($domain);
			return zones(get_domain($_SERVER['HTTP_HOST']));
			//return zones('flamepix.com');
		} else if($a == 'zone' && !empty($zid)){
			return zone($zid);
		} else if($a == 'dev' && !empty($zid)){
			if(isset($_POST['switch'])) {
				return change_development_mode($zid, $_POST['switch']);
			} else {
				return false;
			}
		} else if($a == 'purge' && !empty($zid)){
			return purge($zid);
		} else if($a == 'purge_files' && !empty($zid)){
			if(isset($_POST['files'])) {
				$files = $_POST['files'];//explode(',', $_POST['files']);
				return purge_files($zid, $files);
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function get_domain($domain)
{
	$original = $domain = strtolower($domain);
	if (filter_var($domain, FILTER_VALIDATE_IP)) { return $domain; }
	$arr = array_slice(array_filter(explode('.', $domain, 4), function($value){
		return $value !== 'www';
	}), 0); //rebuild array indexes
	if (count($arr) > 2)
	{
		$count = count($arr);
		$_sub = explode('.', $count === 4 ? $arr[3] : $arr[2]);
		if (count($_sub) === 2) // two level TLD
		{
			$removed = array_shift($arr);
			if ($count === 4) // got a subdomain acting as a domain
			{
				$removed = array_shift($arr);
			}
		}
		elseif (count($_sub) === 1) // one level TLD
		{
			$removed = array_shift($arr); //remove the subdomain
			if (strlen($_sub[0]) === 2 && $count === 3) // TLD domain must be 2 letters
			{
				array_unshift($arr, $removed);
			}
			else
			{
				// non country TLD according to IANA
				$tlds = array(
					'aero',
					'arpa',
					'asia',
					'biz',
					'cat',
					'com',
					'coop',
					'edu',
					'gov',
					'info',
					'jobs',
					'mil',
					'mobi',
					'museum',
					'name',
					'net',
					'org',
					'post',
					'pro',
					'tel',
					'travel',
					'xxx',
				);
				if (count($arr) > 2 && in_array($_sub[0], $tlds) !== false) //special TLD don't have a country
				{
					array_shift($arr);
				}
			}
		}
		else // more than 3 levels, something is wrong
		{
			for ($i = count($_sub); $i > 1; $i--)
			{
				$removed = array_shift($arr);
			}
		}
	}
	elseif (count($arr) === 2)
	{
		$arr0 = array_shift($arr);
		if (strpos(join('.', $arr), '.') === false
			&& in_array($arr[0], array('localhost','test','invalid')) === false) // not a reserved domain
		{
			// seems invalid domain, restore it
			array_unshift($arr, $arr0);
		}
	}
	return join('.', $arr);
}

// Init
if ($core->isLogin() and isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
	header('Content-Type: application/json');
	if($core->is_guest()) exit('{ "error": "Guest user cannot make changes.", "success": false }');
	$response = cloudflare() ?: ['success'=>false];
	echo json_encode($response);
} else {
	echo 'Sorry';
}


?>