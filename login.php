<?php
require_once 'core/init.php';

if (Session::exists('home')) {
    echo '<p>' . Session::flash('home') .'</p>';
    // echo Session::flash('success');
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'u_name' => array('required' => true),
            'pword' => array('required' => true)
        ));

        if ($validation->passed()) {
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('u_name'), Input::get('pword'), $remember);

            if ($login) {
                Redirect::to('index.php');
            } else {
                echo '<p>Sorry, logging in failed.</p>';
            }
        }   else {
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }

    }
}
?>

<form action="" method="post">
    <div class="field">
        <label for="u_name">Username</label>
        <input type="text"  name="u_name" id="u_name" autocomplete="off">
    </div>
    <div class="field">
        <label for="pword">Password</label>
        <input type="password"  name="pword" id="pword" autocomplete="off">
    </div>
    <div class="field">
        <label for="remember">
            <input type="checkbox" name="remember" id="remember"> Remember me
        </label>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Log in">
</form>