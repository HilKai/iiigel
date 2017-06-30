<?php 


	 include_once("database.php");
    
    var_dump($_POST);
  
    $myModule = $ODB->addModul($_POST['sName','language','description']);
   
   

?>