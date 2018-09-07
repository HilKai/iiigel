<?php 
	

    include_once("database.php");
    session_start();
     
    if(!$ODB->isAdmin($_SESSION['user'])and(!$ODB->isInstitutionsLeader($_SESSION['user']))) {
        echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
        $ODB->addGroup($_POST['ModulID'],$_POST['sInstitutionID'],$_POST['sName']);
        if ($_POST['UserID']!=0){
            $newGroupID = $ODB->getGroupIDFromName($_POST['sName']);    
            $ODB->addTrainerToGroup($_POST['UserID'],$newGroupID); 
        }
        header("Location: AdminGroup.php?InstitutionsID=".$_POST['sInstitutionID']);
    }
?>
