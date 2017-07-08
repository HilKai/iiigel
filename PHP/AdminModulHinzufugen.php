<?php 


	 include_once("database.php");
    
    var_dump($_POST);
  
    $myModule = $ODB->addModul($_POST['sName'],$_POST['language'],$_POST['description']);
   
   

?>