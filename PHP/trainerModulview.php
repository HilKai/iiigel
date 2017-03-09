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
    $myGroup = $ODB->getGroupFromID(6);
    for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){ 
	   echo($ODB->getGroupFromID(6)->teilnehmer[$i]->getsFirstName()."<br>");
    }
?>