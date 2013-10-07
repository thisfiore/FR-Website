<?php

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
define("PROTOCOL", $protocol);
define("HOSTNAME", $_SERVER['HTTP_HOST']);

$self = $_SERVER['REQUEST_URI'];

$ds = $self[strlen($self)-1];

$array_self = explode("/",$self);
$array_self = array_filter($array_self);


// echo $ds;
// echo "<pre>";
// print_r($array_self);
// echo "</pre>";
// die;

// impostazione URL corretto
if ($ds != "/") {
	
	if ($array_self[1] != 'home' || $array_self[1] != 'login') {
		header("location:".PROTOCOL.HOSTNAME."/");
	}
	else {
		
		if (isset($_COOKIE['userId']) && !empty($_COOKIE['userId'])) {
			require_once '../web/view/home.php';
		}
		else {
			require_once '../web/view/login.php';
		}
		
	}
	
} 
else {
	
	if (isset($_COOKIE['userId']) && !empty($_COOKIE['userId'])) {
		require_once '../web/view/home.php';
	}
	else {
		require_once '../web/view/login.php';
	}
	
}



?>