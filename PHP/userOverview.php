<?php
    ob_start();
    session_start();
    $myPage = file_get_contents('../HTML/userOverview.html');
    include_once("database.php");
    include_once("Model/user.php");


    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    // select loggedin users detail
    $myUser = $ODB->getUserFromID($_SESSION['user']);
    $myGroups = $ODB->getGroupsFromUserID($_SESSION['user']);
    $search = array('%Vorname%', '%Nachname%', '%UserName%', '%EMail%');
    $replace = array($myUser->getsFirstName(), $myUser->getsLastName(), $myUser->getsUsername(), $myUser->getsEMail());
    $myPage = str_replace($search,$replace,$myPage);
    $myTrainer = [];
    $toAdd = "";
    
    for ($i=0; $i< sizeof($myGroups);$i++){ 
        $myTrainer = $myGroups[$i]->getTrainer();
        $oneTrainer = reset($myTrainer);
        $myBox = file_get_contents('../HTML/groupBox.html');
            $search = array('%Name%', '%Institution%', '%Trainer%', '%Progress%', '%ProgressPercent%','%ModuleLink%','%ModuleName%');
            $replace = array($myGroups[$i]->getsName(), $ODB->getInstitutionFromID($myGroups[$i]-> getInstitutionsID())->getsName(),$oneTrainer->getsFirstName()." ". $oneTrainer->getsLastName(),$myGroups[$i]->getProgressFromUserID($_SESSION['user'])+1,(100*($myGroups[$i]->getProgressFromUserID($_SESSION['user'])+1)/(sizeof ($ODB->getModuleFromID($myGroups[$i]->getModulID()) -> chapter))),"ChapterView.php?moduleID=" . $myGroups[$i]->getModulID() . "&chapterID=" . $myGroups[$i]->getProgressFromUserID($_SESSION['user'])."&groupID=". $myGroups[$i]->getID() ,$ODB->getModuleFromID($myGroups[$i]->getModulID())->getsName());
            $myBox = str_replace($search,$replace,$myBox);
        
        $toAdd = $toAdd . $myBox;
    }
    $myPage=str_replace('%Module%',$toAdd,$myPage);
    echo $myPage;
         
?>