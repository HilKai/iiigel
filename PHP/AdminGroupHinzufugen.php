<?php 
	

	 include_once("database.php");
     
	$myGroup = $ODB->addGroup($_POST['ModulID'],$_POST['sInstitutionID'],$_POST['sName']);
   
    header("Location: AdminGroup.php?InstitutionsID=".$_POST['sInstitutionID']);

?>
