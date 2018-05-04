<?php
require_once("db_files/db_functions.php");
	$db = new db();
	session_start();
	$user_check=$_SESSION['username'];
	$row=$db->getOne("SELECT * FROM hospitals_info WHERE username='$user_check'");
	$hospital =$row['username'];
	if(!isset($hospital)){
			header('Location: login_page.php'); 
	}
?>