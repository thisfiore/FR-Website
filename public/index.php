<?php
// require_once 'Bootstrap.php';

// $documentRoot = str_replace("index.php", "", __FILE__);
// $bootstrap = new Bootstrap($documentRoot);
// $bootstrap->run();

if (isset($_COOKIE['userId']) && !empty($_COOKIE['userId'])) {
	require_once '../web/view/home.php';
}
else {
	require_once '../web/view/login.php';
}

?>