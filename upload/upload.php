<?php
require_once '../core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array(
        'jpg',
        'jpeg',
        'png',
        'pdf'
    );

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 500000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'images/' . $fileNameNew;
                $u_id = $user->data()->u_id;
                $user->upload(array(
                    'u_id' => $u_id,
                    'i_dest' => "/goinfre/vscott/Desktop/MAMP/apache2/htdocs/Camagru/upload/" . $fileDestination,
                    'i_name' => $fileNameNew,
                    'creation_date' => date('Y-m-d H:i:s')
                ));
                move_uploaded_file($fileTmpName, $fileDestination);
                Session::flash('upload', 'Image Uploaded');
                Redirect::to('upload_image.php');
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!"; 
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}