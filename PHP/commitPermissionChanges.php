<?php 
	

	 include_once("database.php");
    session_start();
    if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo false;
    } else {
    echo $ODB->updateCompletePermission(
$_GET['newUserID'],$_GET['newName'],$_GET['newID'],$_GET['newcanView'],$_GET['newcanEdit'],$_GET['newcanCreate'],$_GET['newcanDelete'],$_GET['UserID'],$_GET['Name'],$_GET['ID'],$_GET['canView'],$_GET['canEdit'],$_GET['canCreate'],$_GET['canDelete']);
   
   
		
	}
?>
