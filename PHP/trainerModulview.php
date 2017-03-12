<?php
	 ob_start();
	 session_start();
	 include_once '../HTML/trainerModulview.html';
	 include_once("database.php");
     include_once("Modul/Teilnehmer.php")
	 
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
    // select modul member details
    
?>