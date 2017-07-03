<?php 


	 include_once("database.php");
    
    $myGroup = $ODB->addGroup($_GET['sName'],$_GET['InstitutionID'],$_GET['ModulID']);
   
   

?>
