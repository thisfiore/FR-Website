<?php

// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";
// die;

if (isset($_COOKIE['userId']) && !empty($_COOKIE['userId'])) {
	require_once 'home.php';
}
else {
	require_once 'login.php';
}

?>