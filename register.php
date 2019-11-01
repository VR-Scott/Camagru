<?php
require_once 'core/init.php';

if (Input::exists()) {
    if(Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'u_name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50,
                'unique' => 'users'
            ),
            'pword' => array(
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'pword'
            ),
            'email' => array(
                'required' => true,
                'min' => 2,
                'max' => 100

            )
        ));

        if ($validation->passed()) {
            $user = new User();

            $salt = Hash::salt(32);

            try {
                $user->create(array(
                    'u_name' => Input::get('u_name'),
                    'email' => Input::get('email'),
                    'group' => 1,
                    'pword' => Hash::make(Input::get('pword'), $salt),
                    'salt' => $salt,
                    'u_reg_date' => date('Y-m-d H:i:s')
                    
                ));

                Session::flash('home', 'You are now registered and can log in.');
                Redirect::to('login.php');

            } catch (Exception $e) {
                die($e->getMessage());
            }
            // Session::flash('success', 'You registered successfully!');
            // header('Location: index.php');
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
        <label for ="u_name">Username</label>
        <input type="text" name="u_name" id="u_name" value="<?php echo escape(Input::get('u_name')); ?>" autocomplete="off">
    </div>
    <div class="field">
        <label for ="pword">Choose a password</label>
        <input type="password" name="pword" id="pword">
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