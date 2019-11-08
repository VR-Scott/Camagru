<?php
require_once 'core/init.php';

if (!$u_name = Input::get('user')) {
    Redirect::to('index.php');
} else {
    $user = new User($u_name);
    if (!$user->exists()) {
        Redirect::to(404);
    } else {
        $data = $user->data();
    }
    ?>

    <h3><?php echo escape($data->u_name); ?></h3>
    <p>Email: <?php echo escape($data->email); ?></p>
       
    <?php
}
?>

<div class="field">
        <a href="upload/upload_image.php"> Upload image</a>
</div>