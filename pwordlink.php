<?php
require_once 'core/init.php';
    $u_name = $_GET['user'];
    $l_salt = $_GET['salt'];
?>

<form action="includes/pwchange.inc.php" method="post">
    <input type="hidden" name="u_name" value="<?php echo $u_name?>">
    <input type="hidden" name="salt" value="<?php echo $l_salt?>">
    <div class= "field">
        <label for="password_new">New password</label>
        <input type="password" name="password_new" id="password_new" required=""
        placeholder="Enter desired password" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{6,64}$"
        oninput="setCustomValidity('')" oninvalid="setCustomValidity('Password must be alphanumeric and 6-64 characters long, Containing: a Uppercase, a Lowercase, a digit.')">
    </div>

    <div class= "field">
        <label for="password_new_again">New password again</label>
        <input type="password" name="password_new_again" id="password_new_again" required=""
        placeholder="Enter password again" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{6,64}$"
        oninput="setCustomValidity('')" oninvalid="setCustomValidity('Password must be alphanumeric and 6-64 characters long, Containing: a Uppercase, a Lowercase, a digit.')">
    </div>

    <input type="submit" value="Change" name="reset_pword">
</form>