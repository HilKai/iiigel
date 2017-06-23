<?php 


	 include_once("database.php");
    
    var_dump($_POST);
  
    $myModule = $ODB->addInstitution($_POST['sName']);
   
   

?>
