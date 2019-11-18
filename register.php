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
                'min' => 6,
                'max' => 64
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

            $notify = (Input::get('notify')) ? Input::get('notify') : 0;

            try {
                $user->create(array(
                    'u_name' => Input::get('u_name'),
                    'email' => Input::get('email'),
                    'group' => 1,
                    'pword' => Hash::make(Input::get('pword'), $salt),
                    'salt' => $salt,
                    'confirmed' => 0,
                    'notify' => $notify,
                    'u_reg_date' => date('Y-m-d H:i:s')
                    
                ));
                
                $email = Input::get('email');
                $u_name = Input::get('u_name');
                $subject = 'Signup | Verification';
                $message = 'Thank you for registering. Please click the link to verify your registration:';
                $message .= "<a href='http://localhost:8080/Camagru/confirm.php?user=$u_name&salt=$salt'>Confirm Account</a>";
                $headers = 'From:noreply@camagru.vr.vscott' . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
                mail($email, $subject, $message, $headers);
                Session::flash('home', 'Please check your email for confirmation');
                Redirect::to('index.php');

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
        <p>Username must be alphanumeric beginning with a letter<br>and 2-50 characters long.</p>
        <label for ="u_name">Username</label>
        <input type="text" name="u_name" id="u_name" required="" placeholder="Enter desired username"
        value="<?php echo escape(Input::get('u_name')); ?>"pattern="^[A-Za-z][A-Za-z0-9]{2,49}$" oninput="setCustomValidity('')"
        oninvalid="setCustomValidity('Username must be alphanumeric beginning with a letter and 2-50 characters long.')" autocomplete="off">
    </div>

    <div class="field">
        <label for ="email">Email</label>
        <input type='text' name="email" id="email" required="" placeholder="Enter your email" 
        value ="<?php echo escape(Input::get('email')); ?>"pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,100}$" 
        oninput="setCustomValidity('')" oninvalid="setCustomValidity('Invalid email format')" >
    </div>

    <div class="field">
        <p>Password must be alphanumeric and 6-64 characters long,<br>Containing: a Uppercase, a Lowercase, a digit.</p>
        <label for ="pword">Choose a password</label>
        <input type="password" name="pword" id="pword" required="" placeholder="Enter desired password"
        pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{6,64}$"
        oninput="setCustomValidity('')" oninvalid="setCustomValidity('Password must be alphanumeric and 6-64 characters long, Containing: a Uppercase, a Lowercase, a digit.')">

    </div>
    <div class="field">
        <label for ="password_again">Enter password again</label>
        <input type="password" name="password_again" value="" id="password_again"
        required="" placeholder="Enter password again"
        pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{6,64}$"
        oninput="setCustomValidity('')" oninvalid="setCustomValidity('Password must be alphanumeric and 6-64 characters long, Containing: a Uppercase, a Lowercase, a digit.')">
    </div>

    <div>
        <label for="notify">Notify me</label>
        <input type="checkbox" name="notify" value=1>
    </div>
   
    
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">
</form>
<div class="field">
        <a href="login.php"> Log in</a>
</div>