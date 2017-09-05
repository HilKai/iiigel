<?php 
    include_once("database.php");
	$myGroup = $ODB->addUsertoInstitution($_POST['UserID'],$_POST['InstitutionsID']);
    header("Location: AdminInstitutionDetailView.php?InstitutionsID=".$_POST['InstitutionsID']);
?>
