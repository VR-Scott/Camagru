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

            $login = $user->login(Input::get('u_name'), Input::get('pword'));

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
        <input type="text"  name="u_name" id="u_name" required="" placeholder="Enter your username"
        value="<?php echo escape(Input::get('u_name')); ?>"pattern="^[A-Za-z][A-Za-z0-9]{2,49}$" oninput="setCustomValidity('')"
        oninvalid="setCustomValidity('Invalid Username')" autocomplete="off">
    </div>
    <div class="field">
        <label for="pword">Password</label>
        <input type="password"  name="pword" id="pword" required="" placeholder="Enter your password"
        pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{6,64}$"
        oninput="setCustomValidity('')" oninvalid="setCustomValidity('Invalid Password')" autocomplete="off">
    </div>
   
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Log in">
</form>
<div class="field">
        <a href="register.php"> Register</a>
</div>

<div class="field">
        <a href="forgot.php"> Forgot Password</a>
</div>
