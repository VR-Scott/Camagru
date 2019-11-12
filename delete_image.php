<?php
require_once 'core/init.php';

if (!Input::get("logged_in")){
    Session::flash('login', 'You need to be logged in to delete!');
    Redirect::to('login.php');
}


$db = DB::getInstance();
$i_name = Input::get("i_name");
$path = "./upload/images/" . $i_name;
unlink($path);
$db->delete('images', array('i_name', '=', $i_name));
// $email = ($db->get_property('email','users', array('u_id', '=', $u_id)))[0]->email;
// if (($db->get_property('notify','users', array('u_id', '=', $u_id)))[0]->notify) {
//     $subject = 'You got a comment';
//     $message = 'Your image got a comment.';
//     // $message .= "<a href='http://localhost:8080/Camagru/confirm.php'>Confirm Account</a>";
//     $headers = 'From:noreply@camagru.vr.vscott' . "\r\n";
//     $headers .= "MIME-Version: 1.0" . "\r\n";
//     $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
//     mail($email, $subject, $message, $headers);
// }
Session::flash('upload',' Image Deleted!');
Redirect::to('./upload/upload_image.php');