<?php 
	

	 include_once("database.php");
     
if(!$ODB->idAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
	$myGroup = $ODB->addGroup($_POST['ModulID'],$_POST['sInstitutionID'],$_POST['sName']);
   
    header("Location: AdminGroup.php?InstitutionsID=".$_POST['sInstitutionID']);
}
?>
