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
        $_SESSION['uploaded_image'] = $tmp_path;
    }
    ?>
        
    <?php
}
?>
<html>
    <head>
        <link rel="stylesheet" href="cam.css">
    </head>
    <body>
    <div class="booth">
    <!-- <img id="upload" src="./tmp/tmp.png" alt=""> -->
    <!-- <img id="stick" style="position:absolute; width: 90%;"> -->
    <video id="video" width="100%"></video>
    <img id="stick1" src="./stickers/s1.png" alt="">
    <img id="stick2" src="./stickers/s2.png" alt="">
    <img id="stick3" src="./stickers/s3.png" alt="">
    <canvas id="canvas" width="500" height="380" ></canvas>
    <div class="cambuttons">
        <a href ="#" id="capture" class="capturebtn">Take Photo</a>
        <!-- <canvas id="sticker" width="400" height="300" style="position: absolute;top: 0px;left: 0px;z-index: 2;width: 100%;"></canvas> -->
        
            <button type="button" style="font-size: 1.6vh;" class="" onclick="camReset()">Camera</button>
            <a href ="#" id="save" class="capturebtn">Save</a>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="file">
            <button type="submit" name="submit" id="submit" required="">UPLOAD</button>
        </form>

        
        <!-- <a href ="#" id="upload" class="uploadbtn">Upload</a> -->
    </div>
    <div class="stickers">
        <h3 style="margin: 0;">Stickers</h3>
            <table style="width:100%">
                <tr>
                    <td style="width=33%"><img id="place1" src="./stickers/s1.png" style="width: 70%;"></td>
                    <td style="width=33%"><img id="place2" src="./stickers/s2.png" style="width: 70%;"></td>
                    <td style="width=33%"><img id="place3" src="./stickers/s3.png" style="width: 70%;"></td>
                </tr>
            </table>
            <br/>
            
        </div>
    </div>
    </body>
    <script src="cam.js"></script>
    
</html>