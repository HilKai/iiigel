<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/AdminInstitution.html');
	 include_once("database.php");
    

    $myModuleID = $_GET['moduleID'];
    $myChapterID = $_GET['chapterID'];
    $myUserID = $_SESSION['user'];
    $currentGroupID = $_GET['groupID'];
    $myInstitutionID = $_GET['institutionID']
    
	 // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: ../index.php");
        exit;
	 }

    //redirects User if he is not in this group

    if(!$ODB->isUserinGroup($_SESSION['user'],$currentGroupID)){
        header("Location:  ../index.php");
        exit;   
    }


  
    
    //

    $myModule = $ODB->getModuleFromID($myModuleID);
    $myUser = $ODB->getUserFromId($myUserID);
    $myGroups = $ODB->getGroupsFromUserID($_SESSION['user']);
    $myInstitution = $ODB->getInstitutionFromID($myInstitutionID);

   
    for ($i=0; $i< sizeof($myInstitution->teilnehmer);$i++){   
        $myRow = file_get_contents('../HTML/trainerModulTablerow.html');
            $search = array('%Prename%', '%Lastname%', '%Progress%', '%ProgressPercent%','%ID%');
            $replace = array($myGroup ->teilnehmer[$i]->getsFirstName(), $myGroup ->teilnehmer[$i]->getsLastName(), $myGroup->teilnehmer[$i]->getiFortschritt()+1, (100*($myGroup->teilnehmer[$i]->getiFortschritt()))/(sizeof($myModule->chapter)-1),$myGroup->teilnehmer[$i]->getID());
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
       
    
    }
    
echo $myPage;
?>
