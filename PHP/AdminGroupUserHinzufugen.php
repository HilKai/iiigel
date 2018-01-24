<?php 
    include_once("database.php");
	session_start();
	if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
	$myGroup = $ODB->addUsertoGroup($_POST['UserID'],$_POST['GroupID']);
    header("Location: AdminGroupDetailView.php?GroupID=".$_POST['GroupID']);
	}
?>
