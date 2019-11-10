<?php

	require_once 'config/setup.php';
	require_once 'core/init.php';

	if (Session::exists('home')) {
		echo '<p>' . Session::flash('home') .'</p>';
		// echo Session::flash('success');
	}

	$user = new User();
	if ($user->isLoggedIn()) {
	?>
		<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->u_name); ?>"><?php echo escape( $user->data()->u_name); ?></a>!</p>
		<ul>
			<li><a href="logout.php">Log out</a></li>
			<li><a href="update.php">Update details</a></li>
			<li><a href="change_pwd.php">Change password</a></li>
		</ul>
	<?php

		if($user->hasPermission('admin')) {
			echo '<p>You are an admin.</p>';
		}

	} else {
		echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
	}
	?>

	<div class="field">
			<a href="gallery.php">Gallery</a>
	</div>

	<?php

	

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