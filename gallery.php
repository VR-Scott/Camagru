<?php
require_once 'core/init.php';

if (Session::exists('gallery')) {
    echo '<p>' . Session::flash('gallery') .'</p>';
    // echo Session::flash('success');
}


$user = new User();
$logged_in = ($user->isLoggedIn()) ? 1 : 0 ;
$u_id = $user->data()->u_id;
    


?>
<html>
<head>
</head>
<body>
    <div class="field">
        <a href="index.php">Home</a>
        <br><br><br><br>
    </div>
    <?php
        $page = 0;
        if (isset($_POST["page"])) {
            $page = $_POST["page"];
            $page = ($page * 6) - 6; //counting for 6 images displayed;
        }
        $res = $user->db()->get_gallery($page);
        foreach($res as $key => $value){
            $likes = $user->db()->get_property_count('l_id','likes', 'i_id', $value['i_id']);
            $comments = $user->db()->get_property_count('c_id','comments', 'i_id', $value['i_id']);
            ?>
            <span>
                <a href="http://localhost:8080/Camagru/view_image.php?name=<?php echo $value['i_name']?>&u_id=<?php echo $u_id?>">
                    <img src="http://localhost:8080/Camagru/usergallery/<?php echo $value['i_name'] ?>" width= 30% heigth=30%>
                </a>
                <form action="like.php" method="post">
                    <input type="hidden" name="logged_in" value="<?php echo $logged_in ?>">
                    <input type="hidden" name="u_id" value="<?php echo $value['u_id'] ?>">
                    <input type="hidden" name="liker" value="<?php echo $u_id ?>">
                    <input type="hidden" name="i_id" value="<?php echo $value['i_id'] ?>">
		            <input type="submit" value="Like">
                </form>
                <form action="comment.php" method="post">
                    <input type="hidden" name="logged_in" value="<?php echo $logged_in ?>">
                    <input type="hidden" name="u_id" value="<?php echo $value['u_id'] ?>">
                    <input type="hidden" name="commenter" value="<?php echo $u_id ?>">
                    <input type="hidden" name="i_id" value="<?php echo $value['i_id'] ?>">
                    <input type="text" name="comment"><br>
		            <input type="submit" value="Comment">
                </form>
                <p><?php echo "Likes: " . $likes . " Comments: " . $comments?></p>   
            </span>
            <?php
        }
        $res1 = $user->db()->query("SELECT i_name FROM images");
        $count = $user->db()->gallery_count();
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
    
</body>
</html>