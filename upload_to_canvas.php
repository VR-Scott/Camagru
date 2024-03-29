<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $src_size = getimagesize($fileTmpName);
    // echo $src_size[" height="];
    list($width, $height) = getimagesize($fileTmpName);
    $tmp = imagecreatetruecolor(500, 375);
    $tmp_path = "./tmp/tmp.png";

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    switch($fileActualExt) {
        case "jpg":
            $source = imagecreatefromjpeg($fileTmpName);
            break;
        case "jpeg":
            $source = imagecreatefromjpeg($fileTmpName);
            break;
        case "png":
            $source = imagecreatefrompng($fileTmpName);
            break;
    }

    imagecopyresampled($tmp , $source , 0, 0, 0 , 0, 
    500 , 375 , $width , $height );

    imagepng($tmp, $tmp_path, 9);

    ?>
        <img src="./tmp/tmp.png" alt="">
    <?php

}