<?php
require_once 'core/init.php';
$logged_in = Input::get("logged_in");
$db = DB::getInstance();
$i_name = Input::get("name");
$u_id = Input::get("u_id");
$i_data = $db->get_i_data('images', array('i_name', '=', $i_name));
$p_id = $i_data[0]->u_id;
$username = $db->get_property('u_name', 'users', array('u_id', '=', $p_id))[0]->u_name;
// echo $username = $db->get_property('u_name', 'users', array('u_id', '=', $i_data[0]));
$i_id = $i_data[0]->i_id;
$likes = $db->get_property_count('l_id','likes', 'i_id', $i_id);
$comments = $db->get_property_count('c_id','comments', 'i_id', $i_id);

?>

<h3><?php echo $username?>: </h3>
<div>
    <img src="http://localhost:8080/Camagru/usergallery/<?php echo $i_data[0]->i_name?>" width= 70%>
    <form action="like.php" method="post">
        <input type="hidden" name="logged_in" value="<?php echo $logged_in ?>">
        <input type="hidden" name="src" value="<?php echo  Input::get("src")?>">
        <input type="hidden" name="u_id" value="<?php echo $p_id ?>">
        <input type="hidden" name="liker" value="<?php echo $u_id ?>">
        <input type="hidden" name="i_id" value="<?php echo $i_id ?>">
        <input type="submit" value="Like">
    </form>
    <form action="comment.php" method="post">
        <input type="hidden" name="logged_in" value="<?php echo $logged_in ?>">
        <input type="hidden" name="src" value="<?php echo  Input::get("src")?>">
        <input type="hidden" name="u_id" value="<?php echo $p_id ?>">
        <input type="hidden" name="commenter" value="<?php echo $u_id ?>">
        <input type="hidden" name="i_id" value="<?php echo $i_id ?>">
        <input type="text" name="comment"><br>
        <input type="submit" value="Comment">
    </form>
    <p><?php echo "Likes: " . $likes . " Comments: " . $comments?></p>
</div>

<?php
    if (Input::get("src") == "edit"){
      ?>
            <form action="delete_image.php" method="post">
                <input type="hidden" name="logged_in" value="<?php echo $logged_in ?>">
                <input type="hidden" name="u_id" value="<?php echo $value['u_id'] ?>">
                <input type="hidden" name="i_id" value="<?php echo $value['i_id'] ?>">
                <input type="hidden" name="i_name" value="<?php echo $value['i_name'] ?>">
                <input type="submit" value="Delete">
            </form>
      <?php  
    }
?>


<h3>Comments:</h3>
<br>
<?php 
        $page = 0;
        if (isset($_POST["page"])) {
            $page = $_POST["page"];
            $page = ($page * 6) - 6; //counting for 6 images displayed;
        }
        $comms = ($db->get_comments($i_id, $page));
        foreach($comms as $key => $comm){
            $commenter = $db->get_property('u_name','users',array('u_id', '=', $comm->commenter_id))[0]->u_name ;
            ?>
            <span>
                <p>
                    <?php echo($commenter)?>
                    <br>said:<br>
                    <?php echo escape($comm->comment)?>
                </p>       
            </span>
            <?php
        }
        $a=$comments/6;
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