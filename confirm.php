<?php
   require_once 'core/init.php';
       $user = new User(Input::get('user'));
       $id = $user->data()->u_id;
       $u_salt = $user->data()->salt;
       $confirm = $_GET['salt'];
       if ($u_salt === $confirm) {
           try {
               $user->update(array(
                   'confirmed' => 1
               ), $id);
               Redirect::to('login.php');
           } catch(Exception $e) {
               die("Something went wrong validating your account, please register again, sorry, peasant..");
           }
       }