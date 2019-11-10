<?php
require_once '../core/init.php';

if (Session::exists('upload')) {
    echo '<p>' . Session::flash('upload') .'</p>';
}

    $user = new User();

    if (!$user->isLoggedIn()) {
        Session::flash('home', 'Only logged in users may upload images!');
        Redirect::to('../index.php');
    }
?>
​


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
    <div>

    <div class="field">
        <a href="../index.php">Home</a>
    </div>

    <?php
        $u_id = $user->data()->u_id;
        $page = 0;
        if (isset($_POST["page"])) {
            $page = $_POST["page"];
            $page = ($page * 6) - 6; //counting for 6 images displayed;
        }
        $res = $user->db()->get_user_images($u_id,$page);
        foreach($res as $key => $value){
            ?>
            <span>
                <img src="http://localhost:8080/Camagru/upload/images/<?php echo $value['i_name'] ?>" width= 30% heigth=30%>
                <form action="../delete_image.php" method="post">
                    <input type="hidden" name="logged_in" value="<?php echo $logged_in ?>">
                    <input type="hidden" name="u_id" value="<?php echo $value['u_id'] ?>">
                    <input type="hidden" name="i_name" value="<?php echo $value['i_name'] ?>">
                    <input type="submit" value="Delete">
                </form>  
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
</body>
</html>

<?php

// $info = $user->db()->get_property("i_name", "images", array('u_id', '=', $u_id));
// // var_dump($info);
// foreach($info as $path){
// 	foreach($path as $ar){
// 		echo "<img src=\"http://localhost:8080/Camagru/upload/images/" . $ar . "\" width= 30% heigth=30%>";
// 	}
// }
// foreach($info as $key => $value){
//     echo $value . "<br>";
// 		// echo "<img src=" . $value['i_dest'] . " width= 25% heigth=25%>";
// }
?>