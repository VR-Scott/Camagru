<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'u_name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50,
                'unique' => 'users'
            )
        ));

        if ($validation->passed()) {
            
            try {
                $user->update(array(
                    'u_name' => Input::get('u_name')
                ));

                Session::flash('update', 'Your Username has been updated.');
                Redirect::to('update.php');

            } catch(Exception $e) {
                die($e->getMessage());
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
    <div class="field">
        <label for="u_name">Username</label>
        <input type="text" name="u_name" value="<?php echo escape($user->data()->u_name); ?>">

        <input type="submit" value="Update Username">
        <input type="hidden" name="token" id="token" value="<?php echo Token::generate(); ?>">
    </div>
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