<?php
    include_once('database.php');

	if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
    $ODB->addGroupInvitationLink($_POST['link'],$_POST['GroupID'],date('Y-m-d H:i:s',strtotime($_POST['startdate'])),date('Y-m-d H:i:s',strtotime($_POST['enddate'])));
    header("Location:AdminGroupDetailView.php?GroupID=".$_POST['GroupID']);
	}
?>
