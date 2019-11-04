<?php
require_once 'core/init.php';

if (!$u_name = Input::get('user')) {
    Redirect::to('index.php');
} else {
    $user = new User($u_name);
    if (!$user->exists()) {
        Redirect::to(404);
    } else {
        echo'exists';
    }
}