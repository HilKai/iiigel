<?php 

	if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
	 include_once("database.php");
    
    
  
    $myModule = $ODB->addInstitution($_POST['sName']);
   
	}

?>
