<?php
session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => 'Griffin',
		'db' => 'Camagru'
	),
	'remember' => array(
		'cookie_name' => 'monster',
		'cookie_expiry' => 604800

	),
	'session' => array(
		'session_name' => 'user'
	)
);

spl_autoload_register(function($class)
{
	require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitise.php';
