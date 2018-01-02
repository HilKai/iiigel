<?php 


	 include_once("database.php");
    
    if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
     $ODB->addModul($_POST['sName'],$_POST['language'],$_POST['description']);
   
   header("Location: AdminModulDetail.php?InstitutionsID=".$_POST['sInstitutionID']);
	}
?>
