<?php
require_once '../core/init.php';
$user = new User(Input::get('u_name'));
$l_salt = Input::get('salt');
$id = $user->data()->u_id;
$c_salt = $user->data()->salt;

if ($u_salt === $confirm) {

    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'password_new' => array(
            'required' => true,
            'min' => 6,
        ),
        'password_new_again' => array(
            'required' => true,
            'min' => 6,
            'matches' => 'password_new'
        ),
    ));
    try {
        $salt = Hash::salt(32);
        $user->update(array(
            'pword' => Hash::make(Input::get('password_new'), $salt),
            'salt' => $salt
        ), $id);
        Session::flash('home', 'Your password has been changed');
        Redirect::to('../login.php');
    } catch(Exception $e) {
        die("Something went wrong changing your password, please try again");
    }
}