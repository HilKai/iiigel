<?php
    ob_start();
    session_start();
    $myPage = file_get_contents('../HTML/userOverview.html');
    include_once("database.php");
    include_once("Model/user.php");
	include_once("Navigation.php");


    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: ../index.php");
        exit;
    }

   
    // select loggedin users detail
    $myUser = $ODB->getUserFromID($_SESSION['user']); 
    $myGroups = $ODB->getGroupsFromUserID($_SESSION['user']);
    $search = array('%Vorname%', '%Nachname%', '%UserName%', '%EMail%','%ProfilePicture%','%userID%');
    $replace = array($myUser->getsFirstName(), $myUser->getsLastName(), $myUser->getsUsername(), $myUser->getsEMail(),$ODB->getProfilePicFromID($myUser->getID()), $myUser->getID() );
    $myPage = str_replace($search,$replace,$myPage);
	$myPage = str_replace('%Navigation%',getNavigation(false),$myPage);
	
	
    $myTrainer = [];
    $toAdd = "";
    
    for ($i=0; $i< sizeof($myGroups);$i++){ 
        $myTrainer = $myGroups[$i]->getTrainer();
        $oneTrainer = reset($myTrainer);
        if ($ODB->isTrainerofGroup($_SESSION['user'], $myGroups[$i]->getID())) {
            $link = "trainerModulview.php?groupID=".$myGroups[$i]->getID(); 
            $myBox = file_get_contents('../HTML/groupBoxTrainer.html');
            if (sizeof($ODB->getModuleFromID($myGroups[$i]->getModulID())->chapter)!=0){
                $Progress=($myGroups[$i]->getAverageProgressFromGroup())/sizeof($ODB->getModuleFromID($myGroups[$i]->getModulID())->chapter);
                $ProgressPercent= 100*(($myGroups[$i]->getAverageProgressFromGroup())/sizeof($ODB->getModuleFromID($myGroups[$i]->getModulID())->chapter));
            } else {
                $Progress = 0;
                $ProgressPercent = 0;
            }
        } else {
            $link = "ChapterView.php?moduleID=" . $myGroups[$i]->getModulID() . "&chapterID=" . $myGroups[$i]->getProgressFromUserID($_SESSION['user'])."&groupID=". $myGroups[$i]->getID() ;
            $myBox = file_get_contents('../HTML/groupBoxTN.html');
            if (sizeof($ODB->getModuleFromID($myGroups[$i]->getModulID())->chapter)!=0){
                $Progress=$myGroups[$i]->getProgressFromUserID($_SESSION['user'])+1;
                $ProgressPercent=(100*($myGroups[$i]->getProgressFromUserID($_SESSION['user'])+1)/(sizeof ($ODB->getModuleFromID($myGroups[$i]->getModulID()) -> chapter)));
            } else {
                $Progress = 0;
                $ProgressPercent = 0;    
            }
        }
            if ($oneTrainer != null){
                $search = array('%Name%', '%Institution%', '%Trainer%', '%Progress%', '%ProgressPercent%','%ModuleLink%','%ModuleName%', '%ID%');
                $replace = array($myGroups[$i]->getsName(), $ODB->getInstitutionFromID($myGroups[$i]-> getInstitutionsID())->getsName(),$oneTrainer->getsFirstName()." ". $oneTrainer->getsLastName(),$Progress,$ProgressPercent, $link,$ODB->getModuleFromID($myGroups[$i]->getModulID())->getsName(), "Modul".$i);
                $myBox = str_replace($search,$replace,$myBox);
            } else {
               $search = array('%Name%', '%Institution%', '%Trainer%', '%Progress%', '%ProgressPercent%','%ModuleLink%','%ModuleName%', '%ID%');
                $replace = array($myGroups[$i]->getsName(), $ODB->getInstitutionFromID($myGroups[$i]-> getInstitutionsID())->getsName()," ",$Progress,$ProgressPercent, $link,$ODB->getModuleFromID($myGroups[$i]->getModulID())->getsName(), "Modul".$i);
                $myBox = str_replace($search,$replace,$myBox); 
            }
        $toAdd = $toAdd . $myBox;
    }

    $myPage=str_replace('%Module%',$toAdd,$myPage);
    echo $myPage;
?>
