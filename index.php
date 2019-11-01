<?php

	require_once 'config/setup.php';
	require_once 'core/init.php';

	if (Session::exists('home')) {
		echo '<p>' . Session::flash('home') .'</p>';
		// echo Session::flash('success');
	}

	//UPDATE

	// $userInsert = DB::getInstance()->update('users', 7, array(
	// 		'pword' => 'Dspword',
	// 		'email' => 'dsemail@email.com'
	// ));

	//INSERT

	// $userInsert = DB::getInstance()->insert('users', array(
	// 	'u_name' => 'Dale',
	// 	'email' => 'dale@email.com',
	// 	'group' => '1',
	// 	'pword' => 'Dalespword'
	// ));

	// $user = DB::getInstance()->get('users', array('u_name', '=', 'Admin'));
	// $user = DB::getInstance()->query("SELECT * FROM users");
	// if (!$user->count()) {
	// 	echo 'No user';
	// } else {
	// 	echo $user->first()->u_name, '<br>';
		// foreach($user->results() as $user) {
			// echo $user->u_name, '<br>';
			
		// }
	// }
	// echo Config::get('mysql/host');
	// $users = DB::getInstance()->get('users', array('u_name', '=', 'Admin'));
	// if($users->count()) {
	// 	foreach($users as $user) {
	// 		echo $user->u_name;
	// 	}
	// }
	// $user = DB::getInstance()->get('users', array('u_name', '=', 'Admin'));

	//Delete DB after use.

	// $sql = 'DROP DATABASE ' . $db_name;
	// $stmt = $pdo->prepare($sql);
	// $stmt->execute();
?>