<?php
require_once 'core/init.php';

if (Session::exists('gallery')) {
    echo '<p>' . Session::flash('gallery') .'</p>';
    // echo Session::flash('success');
}


$user = new User();
$logged_in = ($user->isLoggedIn()) ? 1 : 0 ;
    


?>
<html>
<head>
</head>
<body>
    <?php
        $page = 0;
        if (isset($_POST["page"])) {
            $page = $_POST["page"];
            $page = ($page * 6) - 6; //counting for 6 images displayed;
        }
        $res = $user->db()->get_gallery($page);
        foreach($res as $key => $value){
            ?>
            <span>
                <img src="http://localhost:8080/Camagru/usergallery/<?php echo $value['i_name'] ?>" width= 30% heigth=30%>
                <form action="like.php" method="post">
                    <input type="hidden" name="logged_in" value="<?php echo $logged_in ?>">
                    <input type="hidden" name="u_id" value="<?php echo $value['u_id'] ?>">
		            <input type="submit" value="Like">
                </form>
                <form action="comment.php" method="post">
                    <input type="hidden" name="logged_in" value="<?php echo $logged_in ?>">
                    <input type="hidden" name="u_id" value="<?php echo $value['u_id'] ?>">
                    <input type="text" name="comment"><br>
		            <input type="submit" value="Comment">
                </form>
                
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
    <div class="field">
        <a href="index.php">Home</a>
    </div>
</body>
</html>