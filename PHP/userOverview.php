<?php
	 ob_start();
	 session_start();
	 require_once '../HTML/userOverview.html';
	 
	 // if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: index.php");
	  exit;
	 }
	 // select loggedin users detail
	 $res=iiigel_query("SELECT * FROM users WHERE ID=".$_SESSION['user']);
	 $userRow=mysql_fetch_array($res);
?>