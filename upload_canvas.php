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


   }
   
   if ($user) {
      $user->upload(array(
         'i_name' => $baseimage,
         'u_id' => $u_id,
         'creation_date' => date('Y-m-d H:i:s'),
         'i_dest' => $imagepath
      ));
      unlink("./tmp/tmp.png");
   }
   else {
      echo 'failed to post image';
   }
   Session::flash('upload', 'Image saved');
   Redirect::to('cam.php');
?>