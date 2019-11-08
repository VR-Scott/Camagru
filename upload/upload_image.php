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
<?php
$info = $user->db()->get_property('i_dest', 'images', array('u_id', '=', $user->data()->u_id));
foreach($info as $path){
	foreach($path as $ar){
		echo "<img src=" . $ar . " width= 25% heigth=25%>";
	}
}
?>

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
        
    </div>
</body>
</html>