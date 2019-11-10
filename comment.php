<?php
require_once 'core/init.php';

if (!Input::get("logged_in")){
    Session::flash('login', 'You need to be logged in to comment!');
    Redirect::to('login.php');
}

$db = DB::getInstance();
$u_id = Input::get("u_id");
$email = ($db->get_property('email','users', array('u_id', '=', $u_id)))[0]->email;
if (($db->get_property('notify','users', array('u_id', '=', $u_id)))[0]->notify) {
    $subject = 'You got a comment';
    $message = 'Your image got a comment.';
    // $message .= "<a href='http://localhost:8080/Camagru/confirm.php'>Confirm Account</a>";
    $headers = 'From:noreply@camagru.vr.vscott' . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
    mail($email, $subject, $message, $headers);
}
Session::flash('gallery', 'Image commented!');
Redirect::to('gallery.php');