<?php
require_once 'core/init.php';

$user = new User();
$logged_in = ($user->isLoggedIn()) ? 1 : 0 ;
if(!$logged_in) {
    Redirect::to('index.php');
}



if (Session::exists('upload')) {
    echo '<p>' . Session::flash('upload') .'</p>';
}


?>
<html>
    <head>
        <link rel="stylesheet" href="cam.css">
    </head>
    <body>
        <div class="images">
            <?php
                $u_id = $user->data()->u_id;
                $u_name = $user->data()->u_name;
                $page = 0;
                if (isset($_POST["page"])) {
                    $page = $_POST["page"];
                    $page = ($page * 6) - 6; //counting for 6 images displayed;
                }
                $res = $user->db()->get_user_images($u_id,$page);
                foreach($res as $key => $value){
                    $likes = $user->db()->get_property_count('l_id','likes', 'i_id', $value['i_id']);
                    $comments = $user->db()->get_property_count('c_id','comments', 'i_id', $value['i_id']);   
            ?>
            <span>
            <a href="http://localhost:8080/Camagru/view_image.php?name=<?php echo $value['i_name']?>&u_id=<?php
                 echo $u_id?>&logged_in=<?php echo $logged_in ?>&src=edit">
                    <img src="http://localhost:8080/Camagru/usergallery/<?php echo $value['i_name'] ?>" width= 100% >
                </a>
                <!-- <img src="http://localhost:8080/Camagru/usergallery/<?php echo $value['i_name'] ?>" width= 100% > -->
                <form action="delete_image.php" method="post">
                    <input type="hidden" name="logged_in" value="<?php echo $logged_in ?>">
                    <input type="hidden" name="u_id" value="<?php echo $value['u_id'] ?>">
                    <input type="hidden" name="i_id" value="<?php echo $value['i_id'] ?>">
                    <input type="hidden" name="i_name" value="<?php echo $value['i_name'] ?>">
                    <input type="submit" value="Delete">
                </form>
                <p><?php echo "Likes: " . $likes . " Comments: " . $comments?></p>
            </span>
            <?php
                }
                $eq = '=';
                // $res1 = $user->db()->query("SELECT i_name FROM images Where u_id {$eq} {$u_id}");
                $count = $user->db()->user_img_count($u_id);
                $a=$count/6;
                $a=ceil($a);//ceil function rounds up.
                echo "<br><br>";
            ?>
            <form method="post">
            <?php
                for($b = 1; $b <= $a; $b++){
            ?>
            <input type="submit" value="<?php echo $b;?>" name="page">
            <?php
            }
            ?>
        </div>
        <div class="booth">
            <div class="field">
                <a href="index.php"> Home</a>
            </div>
            <div class="field">
                <a href="profile.php"><?php echo $u_name?></a>
            </div>
            <div class="field">
                <a href="logout.php">Log-out</a>
            </div>
        
            <div class="picture">
                <video id="video" width="100%"></video>
                
                <img id="stick1" src="./stickers/s1.png" alt="">
                <img id="stick2" src="./stickers/s2.png" alt="">
                <img id="stick3" src="./stickers/s3.png" alt="">

                <canvas id="canvas" width="500" height="380" ></canvas>
            </div>
            <div class="cambuttons">
                <a href ="#" id="capture" class="capturebtn">Take Photo</a>
                
                    <button type="button" style="font-size: 1.6vh;" class="" onclick="camReset()">Camera</button>
                    <a href ="#" id="save" class="capturebtn">Save</a>
                
            </div>
            
            <a href="./uploading_to_cam.php" id="bob">Get image from Device</a>
            
            <div class="stickers">
                <h3 style="margin: 0;">Stickers</h3>
                <table style="width:100%">
                    <tr>
                        <td style="width=100%"><img id="place1" src="./stickers/s1.png" style="width: 70%;"></td>
                        <td style="width=100%"><img id="place2" src="./stickers/s2.png" style="width: 70%;"></td>
                        <td style="width=100%"><img id="place3" src="./stickers/s3.png" style="width: 70%;"></td>
                    </tr>
                </table>
                <br/>
            </div>
        </div>
        
    </body>
    <script src="cam.js"></script>
    
</html>