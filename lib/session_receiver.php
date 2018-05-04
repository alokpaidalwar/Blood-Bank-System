<?php
	require_once("db_files/db_functions.php");
	$db = new db();
	session_start();
	$user_check=$_SESSION['username'];
	$row=$db->getOne("SELECT * FROM receivers_info WHERE username='$user_check'");
	$receiver =$row['username'];

	if(!isset($receiver)){
			header('Location: login_page.php'); 
	}
?>