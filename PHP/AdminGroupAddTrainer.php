<?php 


	 include_once("database.php");
    
    if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
  
    $myGroup = $ODB->addTrainertoGroup($_POST['UserID']);
   
	}

?>
