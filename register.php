<?php
require_once 'core/init.php';

var_dump(Token::check(Input::get('token')));

if (Input::exists()) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'u_name' => array(
            'required' => true,
            'min' => 2,
            'max' => 50,
            'unique' => 'users'
        ),
        'password' => array(
            'required' => true,
            'min' => 6
        ),
        'password_again' => array(
            'required' => true,
            'matches' => 'password'
        ),
        'email' => array(
            'required' => true,
            'min' => 2,
            'max' => 100

        )
    ));

    if ($validation->passed()) {
        echo 'Passed';
    } else {
        foreach ($validation->errors() as $error) {
            echo $error, '<br>';
        }
    }

}
?>

<form action="" method="post">
    <div class="field">
        <label for ="u_name">Username</label>
        <input type="text" name="u_name" id="u_name" value="<?php echo escape(Input::get('u_name')); ?>" autocomplete="off">
    </div>
    <div class="field">
        <label for ="password">Choose a password</label>
        <input type="password" name="password" id="password">
    </div>
    <div class="field">
        <label for ="password_again">Enter your password again</label>
        <input type="password" name="password_again" value="" id="password_again">
    </div>

    <div class="field">
        <label for ="email">Enter your email</label>
        <input type="text" name="email" value ="<?php echo escape(Input::get('email')); ?>" id="email">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">
</form>