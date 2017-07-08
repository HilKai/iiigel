<?php 
	var_dump($_POST);

	 include_once("database.php");
     
	$myGroup = $ODB->addGroup($_POST['sName'],$_POST['InstitutionID'],$_POST['ModulID']);
   
   

?>
