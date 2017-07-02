<?php 


	 include_once("database.php");
    
    var_dump($_POST);
  
    $myGroup = $ODB->addTrainertoGroup($_POST['UserID']);
   
   
$UserID,$GroupID
?>