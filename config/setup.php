<?php

require_once 'database.php';

$pdo = new PDO("mysql:host=$host", $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'CREATE DATABASE IF NOT EXISTS ' . $db;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = 'USE ' . $db;
$stmt = $pdo->prepare($sql);
$stmt->execute();

$sql = 'CREATE TABLE IF NOT EXISTS users (
	u_id INT AUTO_INCREMENT PRIMARY KEY,
	u_name VARCHAR(50) NOT NULL,
	email VARCHAR(100) NOT NULL,
	`group` INT NOT NULL,
	pword LONGTEXT	NOT NULL,
	u_reg_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = 'INSERT INTO users(`u_name`, `email`, `group`, ) VALUES ("Administrator user", \'{"admin": 1}\')';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = 'CREATE TABLE IF NOT EXISTS `groups` (
	g_id INT AUTO_INCREMENT PRIMARY KEY,
	g_name VARCHAR(50) NOT NULL,
	permissions TEXT)';
$stmt = $pdo->prepare($sql);
$stmt->execute();

$sql = 'INSERT INTO `groups`(`g_name`) VALUES ("Standard user")';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = 'INSERT INTO `groups`(`g_name`, `permissions`) VALUES ("Administrator user", \'{"admin": 1}\')';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sql = 'CREATE TABLE IF NOT EXISTS user_session (
	s_id INT AUTO_INCREMENT PRIMARY KEY,
	u_id INT NOT NULL,
	hash VARCHAR(50) NOT NULL)';
$stmt = $pdo->prepare($sql);
$stmt->execute();
?>




