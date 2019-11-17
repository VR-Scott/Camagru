<?php
require_once 'core/init.php';

if (!Input::get("logged_in")){
    Session::flash('login', 'You need to be logged in to delete!');
    Redirect::to('login.php');
}


$db = DB::getInstance();
$i_name = Input::get("i_name");
$i_id = Input::get("i_id");
$path = "./usergallery/" . $i_name;
unlink($path);
$db->delete('likes', array('i_id', '=', $i_id));
$db->delete('comments', array('i_id', '=', $i_id));
$db->delete('images', array('i_name', '=', $i_name));

Session::flash('upload',' Image Deleted!');
Redirect::to('cam.php');