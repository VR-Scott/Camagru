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
            'email' => array(
                'required' => true,
                'min' => 2,
                'max' => 100
            )
        ));

        if ($validation->passed()) {
            
            try {
                $user->update(array(
                    'email' => Input::get('email')
                ));

                Session::flash('update', 'Your email has been updated.');
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
        <label for="email">email</label>
        <input type="text" name="email" value="<?php echo escape($user->data()->email); ?>">

        <input type="submit" value="Update Email">
        <input type="hidden" name="token" id="token" value="<?php echo Token::generate(); ?>">
    </div>
</form>

<div class="field">
        <a href="update.php"> Update Details</a>
</div>

<div class="field">
        <a href="index.php"> Home</a>
</div>