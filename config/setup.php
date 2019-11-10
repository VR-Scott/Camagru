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
	confirmed TINYINT DEFAULT 0,
	notify	TINYINT DEFAULT 0,
	u_reg_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
$stmt = $pdo->prepare($sql);
$stmt->execute();

$sql = "SELECT count(*) FROM `users` WHERE BINARY u_name = 'Admin'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_rows = $stmt->fetchColumn();
if(!$number_of_rows) {
	$sql = 'INSERT INTO users(`u_name`, `email`, `group`, `confirmed`, `notify`, `pword`, `salt`)
	VALUES ("Admin", "vaughan.r.scott@gmail.com", 2, 1, 1, "' . $hash . '", "' . $s_hash . '")';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
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
}

$sql = "SELECT count(*) FROM `groups` WHERE g_name = 'Administrator user'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_rows = $stmt->fetchColumn();
if(!$number_of_rows) {
	$sql = 'INSERT INTO `groups`(`g_name`, `permissions`) VALUES ("Administrator user", \'{\r\n\"admin\": 1,\r\n\"mod\": 1\r\n}\')';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
}


$sql = 'CREATE TABLE IF NOT EXISTS user_session (
	s_id INT AUTO_INCREMENT PRIMARY KEY,
	u_id INT NOT NULL,
	hash VARCHAR(64) NOT NULL)';
$stmt = $pdo->prepare($sql);
$stmt->execute();

$sql = 'CREATE TABLE IF NOT EXISTS images (
	i_id INT AUTO_INCREMENT PRIMARY KEY,
	u_id INT NOT NULL,
	i_dest VARCHAR(130) NOT NULL,
	i_name VARCHAR(64) NOT NULL,
	creation_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
$stmt = $pdo->prepare($sql);
$stmt->execute();
?>