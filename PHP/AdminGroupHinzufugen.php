<?php 


	 include_once("database.php");
    
    $myGroup = $ODB->addGroup($_POST['sName'],$_POST['InstitutionID'],$_POST['ModulID']);
   
   

?>
