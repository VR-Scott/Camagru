<?php
	require_once 'config/setup.php';
	require_once 'core/init.php';

	$user = DB::getInstance()->query("SELECT u_name  FROM users WHERE u_name = ?", array('alex',));

	if($user->error()) {
		echo 'No User';
	} else {
		echo 'OK!';
	}
?>