<?php
	require_once 'config/setup.php';
	require_once 'core/init.php';

	$user = DB::getInstance()->get('users', array('u_name', '=', 'alex'));

	if($user->error()) {
		echo 'No User';
	} else {
		echo 'OK!';
	}
?>