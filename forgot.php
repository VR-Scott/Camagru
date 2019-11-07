<?php
require_once 'core/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'u_name' => array('required' => true)
        ));
        if ($validation->passed()) {
            $user = new User($u_name = Input::get('u_name'));
            if (!$user->find($u_name))
            {
                Session::flash('home', 'No such User');
                Redirect::to('index.php');
            } else {
                $salt = $user->data()->salt;
                $email = $user->data()->email;
                $subject = 'Forgot password';
                $message = 'Please click the link to change your password:';
                $message .= "<a href='http://localhost:8080/Camagru/pwordlink.php?user=$u_name&salt=$salt'>Change Password</a>";
                $headers = 'From:noreply@camagru.vr.vscott' . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
                mail($email, $subject, $message, $headers);
                Session::flash('home', 'Please check your email for link to change your password');
                Redirect::to('index.php');
            }
        }
    }
}
?>

<form action="" method="post">
    <div class="field">
        <label for="u_name">Username</label>
        <input type="text"  name="u_name" id="u_name" required="" placeholder="Enter your username"
        value="<?php echo escape(Input::get('u_name')); ?>"pattern="^[A-Za-z][A-Za-z0-9]{2,49}$"
        oninput="setCustomValidity('')" oninvalid="setCustomValidity('Invalid Username')" autocomplete="off">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Send Email">
</form>