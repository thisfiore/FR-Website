<?php
require_once '../app/Bootstrap.php';

$documentRoot = str_replace("index.php", "", __FILE__);
$bootstrap = new Bootstrap($documentRoot);
$bootstrap->run();

?>
