<?php
	 ob_start();
	 session_start();
	 require_once '../HTML/trainerModulview.html';
	 require_once("database.php");
	 
	 // if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: index.php");
	  exit;
	 }
	 // select loggedin users detail
	 $query = "SELECT * FROM users WHERE ID=".$_SESSION['user'];
	 $res=$ODB->query($query);
	 $userRow=mysqli_fetch_array($res);
?>