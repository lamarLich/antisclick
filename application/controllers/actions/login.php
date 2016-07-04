<?php
session_start();
	$pdo = include "createpdo.php";
	$login = $_POST['login'];
	$password = $_POST['password'];

	$pdo= $pdo->prepare('SELECT * FROM `user` WHERE `login`= ?');
	$pdo->execute(array($login));
	$passDB=$pdo->fetchAll()[0]['password'];
	if ($passDB == md5($password)) {
		$_SESSION['admin']=true;
		$_SESSION['login']=$_POST['login'];
		header("Location: ../panel.php");
	}
	else {
		header("Location: ../index.php?pass=bad");
	}
	
?>