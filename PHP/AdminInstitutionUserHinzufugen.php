<?php 
    include_once("database.php");
	$myGroup = $ODB->addUsertoInstitution($_POST['UserID'],$_POST['InstitutionID']);
    header("Location: AdminInstitutionDetailView.php?InstitutionID=".$_POST['InstitutionID']);
?>
