<?php
$host = 'localhost';
$username = 'root';
$password = 'root42';
$db_name = 'Camagru';
$s_hash = bin2hex(random_bytes(32));
// $hash = password_hash("Admin", PASSWORD_DEFAULT);
$hash = hash('sha256', "Admin1". $s_hash)
?>