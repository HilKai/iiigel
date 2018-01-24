<?php 


	 include_once("database.php");
session_start();
    
    if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
  
    $myGroup = $ODB->addTrainertoGroup($_POST['UserID']);
   
	}

?>
