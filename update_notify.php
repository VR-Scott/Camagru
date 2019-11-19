<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        
        $notify = (Input::get('notify')) ? Input::get('notify') : 0;
        try {
            $user->update(array(
                'notify' => $notify
            ));

            Session::flash('update', 'Your notification settings have been updated.');
            Redirect::to('update.php');

        } catch(Exception $e) {
            die($e->getMessage());
        }
    }
}

?>

<form action="" method="post">
    <div class="field">
            <p>Check the box if you want to be notified<br>OR leave it un-checked<br>Then click "Update notify"</p>
            <label for="notify">Notify me</label>
            <input type="checkbox" name="notify" value=1>
        <input type="submit" value="Update notify">
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