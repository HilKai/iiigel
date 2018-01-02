<?php 
    include_once("database.php");

	if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
	$myGroup = $ODB->addUsertoInstitution($_POST['UserID'],$_POST['InstitutionsID']);
    header("Location: AdminInstitutionDetailView.php?InstitutionsID=".$_POST['InstitutionsID']);
	}
?>
