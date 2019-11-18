<?php
require_once 'core/init.php';


if (!(Input::get("logged_in"))){
    Session::flash('login', 'You need to be logged in to comment!');
    Redirect::to('login.php');
}

$db = DB::getInstance();
$u_id = Input::get("u_id");
$email = ($db->get_property('email','users', array('u_id', '=', $u_id)))[0]->email;
$commenter_id = Input::get("commenter");
$i_id = Input::get("i_id");
$comment = Input::get("comment");

if (($db->get_property('notify','users', array('u_id', '=', $u_id)))[0]->notify) {
    $subject = 'You got a comment';
    $message = 'Your image got the following comment:' . "\r\n" . $comment;
    $headers = 'From:noreply@camagru.vr.vscott' . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
    mail($email, $subject, $message, $headers);
}
$db->insert('comments', array(
    'i_id' => $i_id,
    'u_id' => $u_id,
    'commenter_id' => $commenter_id,
    'creation_date' => date('Y-m-d H:i:s'),
    'comment' => $comment
));
if (Input::get("src") === 'gallery') {
    Session::flash('gallery', "Comment sent!");
    Redirect::to('gallery.php');
} else {
    Session::flash('upload', "Comment sent!");
    Redirect::to('cam.php');
}
