<?php

require_once '/goinfre/vscott/Desktop/MAMP/apache2/htdocs/Camagru/config/database.php';

session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => $host,
		'username' => $username,
		'password' => $password,
		'db_name' => $db_name
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800

	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

spl_autoload_register(function($class)
{
	require_once '/goinfre/vscott/Desktop/MAMP/apache2/htdocs/Camagru/classes/' . $class . '.php';
});

require_once '/goinfre/vscott/Desktop/MAMP/apache2/htdocs/Camagru/functions/sanitise.php';
// require_once 'functions/sanitise.php';
if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {

	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('user_session', array('hash', '=', $hash));

	if ($hashCheck->count()) {
		$user = new User($hashCheck->first()->u_id);
		$user->login();
	}
}
