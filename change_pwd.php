<?php
require_once 'core/init.php';

    $user = new User();

    if (!$user->isLoggedIn()) {
        Redirect::to('index.php');
    }

    if(Input::exists()) {
        if (Token::check(Input::get("token"))) {

            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'password_current' => array(
                    'required' => true,
                    'min' => 6,
                ),
                'password_new' => array(
                    'required' => true,
                    'min' => 6,
                ),
                'password_new_again' => array(
                    'required' => true,
                    'min' => 6,
                    'matches' => 'password_new'
                ),
            ));
            if ($validation->passed()) {

                if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->pword) {
                    echo 'Your current password is wrong.';
                } else {
                    $salt = Hash::salt(32);
                    $user->update(array(
                        'pword' => Hash::make(Input::get('password_new'), $salt),
                        'salt' => $salt
                    ));
                    
                    Session::flash('home', 'Your password has been changed.');
                    Redirect::to('index.php');
                }
            } else {
                foreach ($validation->errors() as $error) {
                    echo $error, '<br>';
                }
            }
        }
    }
?>

<form action="" method="post">
    <div class= "field">
        <label for="password_current">Current password</label>
        <input type="password" name="password_current" id="password_current"
        required="" placeholder="Enter current password"
        pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{6,64}$"
        oninput="setCustomValidity('')" oninvalid="setCustomValidity('Invalid Password')">
    </div>

    <div class= "field">
        <label for="password_new">New password</label>
        <input type="password" name="password_new" id="password_new"
        required="" placeholder="Enter new password"
        pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{6,64}$" oninput="setCustomValidity('')"
        oninvalid="setCustomValidity('Password must be alphanumeric and 6-64 characters long, Containing: a Uppercase, a Lowercase, a digit.')">
    </div>

    <div class= "field">
        <label for="password_new_again">New password again</label>
        <input type="password" name="password_new_again" id="password_new_again"
        required="" placeholder="Enter new password again"
        pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{6,64}$" oninput="setCustomValidity('')"
        oninvalid="setCustomValidity('Password must be alphanumeric and 6-64 characters long, Containing: a Uppercase, a Lowercase, a digit.')">
    </div>

    <input type="submit" value="Change">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>

<div class="field">
        <a href="logout.php">log-out</a>
</div>
<div class="field">
        <a href="update.php"> Update Details</a>
</div>

<div class="field">
        <a href="index.php"> Home</a>
</div>