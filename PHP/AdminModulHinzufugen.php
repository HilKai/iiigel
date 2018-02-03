<?php 
	

	 include_once("database.php");
    session_start();
    if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
     $ODB->addModule($_GET['sName'],$_GET['sLanguage'],$_GET['sDescription']);
   
   header("Location:".$_SERVER['HTTP_REFERER']);
	}
?>
