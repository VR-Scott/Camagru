<?php
require_once 'core/init.php';

    $user = new User();

    if (!$user->isLoggedIn()) {
        Session::flash('home', 'Only logged in users may upload images!');
        Redirect::to('index.php');
    }
?>



<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <button type="submit" name="submit">UPLOAD</button>
    </form>
</body>
</html>