<?php
    require_once 'core/init.php';

    if (Session::exists('update')) {
        echo '<p>' . Session::flash('update') .'</p>';
        // echo Session::flash('success');
    }

    

?>
<div class="field">
        <a href="logout.php">log-out</a>
</div>
<div class="field">
        <a href="update_email.php"> Update Email</a>
</div>

<div class="field">
        <a href="update_uname.php"> Update Username</a>
</div>

<div class="field">
        <a href="change_pwd.php"> Update Password</a>
</div>

<div class="field">
        <a href="update_notify.php"> Update Notification</a>
</div>

<div class="field">
        <a href="index.php"> Home</a>
</div>