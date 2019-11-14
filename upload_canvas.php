<?php
   require_once './core/init.php';

   $user = new User();
   $username= $user->data()->u_name;
   $u_id = $user->data()->u_id;
   if (!$user->isLoggedIn()) {
    Redirect::to('login.php');
    }
   $layer1 = $_POST["baseimage"];
//    $layer2 = $_POST["overlayimage"];

   if(!empty($layer1) && !empty($username)){
    $baseimage = $username.time().".png";
    $imagepath = "./usergallery/".$baseimage;
    $imgurl = str_replace("data:image/png;base64,", "", $layer1);
    $imageurl = str_replace(" ", "+", $imgurl);
    $imgdecode = base64_decode($imageurl);
    file_put_contents($imagepath, $imgdecode);
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
   }
   else {
      echo 'failed to post image';
   }
        

?>