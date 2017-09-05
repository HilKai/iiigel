<?php 
    include_once("database.php");
	$myGroup = $ODB->addUsertoGroup($_POST['UserID'],$_POST['GroupID']);
    header("Location: AdminGroupDetailView.php?GroupID=".$_POST['GroupID']);
?>
