<?php
   require_once './core/init.php';

   $user = new User();
   $username= $user->data()->u_name;
   $u_id = $user->data()->u_id;
   if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
    }
   $layer1 = $_POST["baseimage"];

   if(!empty($layer1) && !empty($username)){

      $baseimage = $username.time().".png";
      $imagepath = "./usergallery/".$baseimage;

      $imgurl = str_replace("data:image/png;base64,", "", $layer1);
      $imageurl = str_replace(" ", "+", $imgurl);
      $imgdecode = base64_decode($imageurl);
      file_put_contents($imagepath, $imgdecode);

      $source = imagecreatefrompng($imagepath);
      $tmp = imagecreatetruecolor(500, 375);
      list($width, $height) = getimagesize($imagepath);
      
      imagecopyresampled($tmp , $source , 0, 0, 0 , 0, 
      500 , 375 , $width , $height );
      
      
      

      
      if(isset($_POST["sticker1"])){
         $sticker1 = imagecreatefrompng("./stickers/s1.png");
         
         // $dest = imagecreatefrompng($imagepath);
         imagecopyresampled($tmp, $sticker1, 375, 285, 0, 0, 125, 95, 500, 375); 
         imagepng($tmp, $imagepath);
         imagedestroy($sticker1);
         // imagedestroy($src);
      }

      if(isset($_POST["sticker2"])){
         $sticker2 = imagecreatefrompng("./stickers/s2.png");
         
         // $dest = imagecreatefrompng($imagepath);
         imagecopyresampled($tmp, $sticker2, 0, 0, 0, 0, 125, 95, 500, 375); 
         imagepng($tmp, $imagepath);
         imagedestroy($sticker2);
         // imagedestroy($src);
      }

      if(isset($_POST["sticker3"])){
         $sticker3 = imagecreatefrompng("./stickers/s3.png");
         
         // $dest = imagecreatefrompng($imagepath);
         imagecopyresampled($tmp, $sticker3, 0, 280, 0, 0, 125, 95, 500, 375); 
         imagepng($tmp, $imagepath);
         imagedestroy($sticker3);
         // imagedestroy($src);
      }


      imagepng($tmp, $imagepath, 9);

      ///////////////////////////////////////////////////////////

      // $source = imagecreatefrompng("./stickers/dnd_beyond.png");

      // $tmp = imagecreatetruecolor(500, 375);
      // imagealphablending($tmp, false);
      // imagesavealpha($tmp, true);
      // $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
      // imagefilledrectangle($tmp, 0, 0, 500, 375, $transparent);
      // list($width, $height) = getimagesize("./stickers/dnd_beyond.png");
      // $tmp_path = "./stickers/s1.png";
      // imagecopyresampled($tmp , $source , 0, 0, 0 , 0, 
      // 500 , 375 , $width , $height );
      
      // imagepng($tmp, $tmp_path, 9);
      /////////////////////////////////////////////////////////



      // if(isset($_POST["sticker2"])){
      //    $sticker2 = $_POST["sticker2"];
      //    $s2_img = "overlay".time().".png";
      //    $s2_path = "./usergallery/".$s2_img;
      //    $s2_url = str_replace("data:image/png;base64,", "", $sticker2);
      //    $s2_url = str_replace(" ", "+", $s2_url);
      //    $s2_decode = base64_decode($s2_url);
      //    file_put_contents($s2_path, $s2_decode);
         
      //    $dest = imagecreatefrompng($imagepath);
      //    $src = imagecreatefrompng($s2_path);
      //    imagecopyresampled($dest, $src, 0, 0, 0, 0, 640, 480, 500, 380); 
      //    imagepng($dest, $imagepath);
      //    imagedestroy($dest);
      //    imagedestroy($src);
      //    unlink($s2_path);
      // }


      


      // if(isset($_POST["sticker3"])){
      //    $sticker3 = $_POST["sticker3"];
      //    $s3_img = "overlay".time().".png";
      //    $s3_path = "./usergallery/".$s3_img;
      //    $s3_url = str_replace("data:image/png;base64,", "", $sticker3);
      //    $s3_url = str_replace(" ", "+", $s3_url);
      //    $s3_decode = base64_decode($s3_url);
      //    file_put_contents($s3_path, $s3_decode);
         
         // $dest = imagecreatefrompng($imagepath);
         // $src = imagecreatefrompng($s3_path);
         // imagecopyresampled($dest, $src, 0, 0, 0, 0, 640, 480, 500, 380); 
         // imagepng($dest, $imagepath);
         // imagedestroy($dest);
         // imagedestroy($src);
         // unlink($s3_path);
      // }
   
   }

//    if(isset($layer2)){
//       $overlayimage = "overlay".time().".png";
//       $overlaypath = "./usergallery/".$overlayimage;
//       $imgurl = str_replace("data:image/png;base64,", "", $layer2);
//       $imageurl = str_replace(" ", "+", $imgurl);
//       $imgdecode = base64_decode($imageurl);
//       file_put_contents($overlaypath, $imgdecode);
//    }
//    if(isset($layer1) && isset($layer2)){
//          $dest = imagecreatefrompng($imagepath);
//          $src = imagecreatefrompng($overlaypath);
//          imagecopyresampled($dest, $src, 0, 0, 0, 0, 640, 480, 500, 380); 
//          imagepng($dest, $imagepath);
//          imagedestroy($dest);
//          imagedestroy($src);
//          unlink($overlaypath);
//    }
   
   if ($user) {
      $user->upload(array(
         'i_name' => $baseimage,
         'u_id' => $u_id,
         'creation_date' => date('Y-m-d H:i:s'),
         'i_dest' => $imagepath
      ));
      // unlink("./tmp/tmp.png");
   }
   else {
      echo 'failed to post image';
   }
        

?>