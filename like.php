<?php
require_once 'core/init.php';

if (!Input::get("logged_in")){
    Session::flash('login', 'You need to be logged in to like!');
    Redirect::to('login.php');
}

$db = DB::getInstance();
$u_id = Input::get("u_id");
$email = ($db->get_property('email','users', array('u_id', '=', $u_id)))[0]->email;
$liker_id = Input::get("liker");
$i_id = Input::get("i_id");

if($status = $db->get_like_status($liker_id, $i_id))
{
    // var_dump($status);
    // echo "bye";
    $l_id = (($db->get_like_id($liker_id, $i_id))[0]->l_id);
    $db->delete('likes', array('l_id', '=', $l_id));
    Session::flash('gallery', 'Image Un-liked!');
    Redirect::to('gallery.php');
} else {
    // echo "hello";
    // var_dump($status);
    if (($db->get_property('notify','users', array('u_id', '=', $u_id)))[0]->notify) {
        $subject = 'You got a like';
        $message = 'Your image got a like.';
        $headers = 'From:noreply@camagru.vr.vscott' . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type:text/html;charset=UTF-8". "\r\n";
        mail($email, $subject, $message, $headers);
    }
    $db->insert('likes', array(
        'i_id' => $i_id,
        'u_id' => $u_id,
        'liker_id' => $liker_id,
        'creation_date' => date('Y-m-d H:i:s'),
        'status' => 1
    ));
    Session::flash('gallery', 'Image liked!');
    Redirect::to('gallery.php');
}
