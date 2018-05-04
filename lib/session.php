<?php
	require_once("db_files/db_functions.php");
	$db = new db();
	session_start();
	if(isset($_SESSION['username'])){
		$user_check=$_SESSION['username'];

		$row=$db->getOne("SELECT * FROM receivers_info WHERE username='$user_check'");
		$receiver =$row['username'];
		if(isset($receiver)){
			header('Location: index.php');
		}

		$row=$db->getOne("SELECT * FROM hospitals_info WHERE username='$user_check'");
		$hospital =$row['username'];
		if(isset($hospital)){
			header("Location: view_requests.php");
		}
	}
?>