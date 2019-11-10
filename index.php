<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

//  load configuration and helper
//   functions first.
include_once (ROOT. DS . 'config' . DS . 'config.php');
require_once ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php';



// Autoload classes
function autoload($className) {
	if (file_exists(ROOT . DS . 'core' . DS . $className . '.php')) {
		require_once ROOT . DS . 'core' . DS . $className . '.php';
	} else if (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
		require_once ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php';
	} else if (file_exists(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php')) {
		require_once ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php';
	}
}

//recommended to use because the __autoload() function has been deprecated
//and use of it is highly discouraged.
spl_autoload_register('autoload');
session_start();

$url = isset($_SERVER['PATH_INFO']) ?
	explode("/", ltrim($_SERVER['PATH_INFO'], '/')) : [];

if (Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
	Users::loginUserFromCookie();
}
// Route the request
Router::route($url);
