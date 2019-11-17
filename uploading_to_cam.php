
<?php
require_once 'core/init.php';
echo "hello";
$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (isset($_POST["submit"])) {
    // var_dump ($_POST["file"]);
    

    $file = $_FILES["file"];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    if ($fileTmpName)
    {
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
    }
    Redirect::to('cam.php');
}
?>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="file">
    <button type="submit" name="submit" id="submit" required="">UPLOAD</button>
</form>
