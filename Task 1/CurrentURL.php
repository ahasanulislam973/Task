<?php
$currentUrl = "http://" . $_SERVER['HTTP_HOST'] . "" . $_SERVER['REQUEST_URI'];
echo $currentUrl;

/*$hostname = getenv('HTTP_HOST'); // get host name
define('API_DIRECTORY', 'bot_service_api');
define('API_BASE_PATH', 'http://' . $hostname . '/' . API_DIRECTORY);

echo constant("API_BASE_PATH");*/

/*define('BASE_PATH', dirname(dirname(__FILE__)));
define('INCLUDE_DIR', BASE_PATH . "/includes/");

echo constant("INCLUDE_DIR");*/

?>