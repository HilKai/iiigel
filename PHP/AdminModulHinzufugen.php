<?php 


	 include_once("database.php");
    
    
     $ODB->addModul($_POST['sName'],$_POST['language'],$_POST['description']);
   
   header("Location: AdminModulDetail.php?InstitutionsID=".$_POST['sInstitutionID']);

?>
