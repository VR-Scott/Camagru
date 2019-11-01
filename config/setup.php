<?php

require_once 'database.php';

$pdo = new PDO("mysql:host=$host", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'CREATE DATABASE IF NOT EXISTS ' . $db_name;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = 'USE ' . $db_name;
$stmt = $pdo->prepare($sql);
$stmt->execute();

$sql = 'CREATE TABLE IF NOT EXISTS users (
	u_id INT AUTO_INCREMENT PRIMARY KEY,
	u_name VARCHAR(50) NOT NULL,
	email VARCHAR(100) NOT NULL,
	`group` INT NOT NULL,
	pword VARCHAR(64) NOT NULL,
	salt VARCHAR(350) NOT NULL,
	u_reg_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
$stmt = $pdo->prepare($sql);
$stmt->execute();

$sql = "SELECT count(*) FROM `users` WHERE u_name = 'Admin'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_rows = $stmt->fetchColumn();
if(!$number_of_rows) {
	$sql = 'INSERT INTO users(`u_name`, `email`, `group`, `pword`, `salt`)
	VALUES ("Admin", "vaughan.r.scott@gmail.com", 1, "' . $hash . '", "salt")';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
} else {
	echo "not inserting Admin <br>";
}
$sql = 'CREATE TABLE IF NOT EXISTS `groups` (
	g_id INT AUTO_INCREMENT PRIMARY KEY,
	g_name VARCHAR(50) NOT NULL,
	permissions TEXT)';
$stmt = $pdo->prepare($sql);
$stmt->execute();

$sql = "SELECT count(*) FROM `groups` WHERE g_name = 'Standard user'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_rows = $stmt->fetchColumn();
if(!$number_of_rows) {
	$sql = 'INSERT INTO `groups`(`g_name`) VALUES ("Standard user")';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
} else {
	echo "not inserting Standard group <br>";
}

$sql = "SELECT count(*) FROM `groups` WHERE g_name = 'Administrator user'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_rows = $stmt->fetchColumn();
if(!$number_of_rows) {
	$sql = 'INSERT INTO `groups`(`g_name`, `permissions`) VALUES ("Administrator user", \'{"admin": 1}\')';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
} else {
	echo "not inserting Admin group <br>";
}
$sql = 'CREATE TABLE IF NOT EXISTS user_session (
	s_id INT AUTO_INCREMENT PRIMARY KEY,
	u_id INT NOT NULL,
	hash VARCHAR(50) NOT NULL)';
$stmt = $pdo->prepare($sql);
$stmt->execute();


?>