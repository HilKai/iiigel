<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/trainerModulview.html');
	 include_once("database.php");
	 $grey = "#ddd";
	 $red = "#ff0000";
	 $color = $grey;

	 $handIn=[];
    
    
    $currentGroupID = $_GET['groupID'];
    $myUserID = $_SESSION['user'];
   
	 
	 // if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: ../index.php");
	  exit;
	 }

    if( !$ODB->isTrainerofGroup($_SESSION['user'],$currentGroupID) ) {
	  header("Location: ../index.php");
	  exit;
	 }   
    

    //
    $myGroup = $ODB->getGroupFromID($currentGroupID);
    $myModule = $ODB->getModuleFromID($myGroup->getModulID());
    $search = array('%Gruppenname%', '%Institution%','%GroupID%');
    $replace = array($myGroup->getsName(), $ODB->getInstitutionFromID($myGroup-> getInstitutionsID())->getsName(), $currentGroupID);
    $myPage = str_replace($search,$replace,$myPage);

    // select modul member details
    $toAdd = "";

    $myModuleID = $myModule->getID();

    if ($_POST){
        
        if(isset($_POST['levelUpforAll'])){
            $ODB->setFortschrittforallUsersinGroup($_POST['levelUpforAll'],$currentGroupID);
            header("Refresh:0");   
        }
        if(isset($_POST['levelUp'])){
            for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
                if($myGroup->teilnehmer[$i]->getID() ==  $_POST['levelUp']) {
                    if($myGroup->teilnehmer[$i]->getiFortschritt()<sizeof($myModule->chapter)-1){
                        $id =$myGroup ->teilnehmer[$i]->getID();
                        $ODB->setFortschrittFromUserinGroup($id,$currentGroupID);
                        header("Refresh:0");     
                    }
                }
            }
        }
        
        if(isset($_POST['acceptHandIn'])){
            for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
                if($myGroup->teilnehmer[$i]->getID() ==  $_POST['acceptHandIn']) {
                        $id =$myGroup ->teilnehmer[$i]->getID();
                        $ODB->acceptHandIn($id,$currentGroupID);
						$ODB->setFortschrittFromUserinGroup($id,$currentGroupID);
                        header("Refresh:0");     
                }
            }
            
        }
		
		 if(isset($_POST['rejectHandIn'])){
            for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
                if($myGroup->teilnehmer[$i]->getID() ==  $_POST['rejectHandIn']) {
                        $id =$myGroup ->teilnehmer[$i]->getID();
                        $ODB->deleteHandIn($id,$currentGroupID);
                        header("Refresh:0");     
                }
            }
            
        }
        
   }
 
    
   for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){ 
	   		$handIn[$myGroup->teilnehmer[$i]->getID()] = $ODB->getHandIn($myGroup->teilnehmer[$i]->getID(), $myGroup->getID());
        	$myRow = file_get_contents('../HTML/trainerModulTablerow.html');
            $search = array('%Prename%', '%Lastname%', '%Progress%', '%ProgressPercent%','%ID%');
            $replace = array($myGroup ->teilnehmer[$i]->getsFirstName(), $myGroup ->teilnehmer[$i]->getsLastName(), $myGroup->teilnehmer[$i]->getiFortschritt()+1, (100*($myGroup->teilnehmer[$i]->getiFortschritt()))/(sizeof($myModule->chapter)-1),$myGroup->teilnehmer[$i]->getID());
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
       
    
    }

//Link setzen im Toggle Button
   
        
        $link = "../PHP/ChapterView.php?moduleID=".$myModuleID."&chapterID=0&groupID=".$currentGroupID;
        $search = array('%TogglelinkK%');
        $replace = array($link);
        $myPage = str_replace($search,$replace,$myPage); 
    
       
    
    $myPage=str_replace('%Tablerow%',$toAdd,$myPage);

    //create DropDown Chapter List
    $toAdd = ""; //Hinzugefügter HTML Code
   for ($i=0; $i< sizeof($myModule->chapter);$i++){  
            $myRow = file_get_contents('../HTML/ChapterDropdownListItem.html');
            $search = array('%ChapterTitle%');
            $replace = array($myModule ->chapter[$i]->getsTitle());
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
       
     
       
        
    }
        $myPage=str_replace('%ChapterDropDownItems%',$toAdd,$myPage);

    $toAdd = "";
    $aktiveLinks = $ODB->getAllAktiveLinksFromGroup($myGroup->getID());
    for ($i=0; $i< sizeof($aktiveLinks);$i++){  
            $myRow = file_get_contents('../HTML/trainerModulviewAktiveLinktitem.html');
            $search = array('%LinkString%','%endDate%');
            $replace = array("www.iii"."gel.de/index.php?reg=".$aktiveLinks[$i] ->getLink(),$aktiveLinks[$i]->getEndDatum());
            $myRow = str_replace($search,$replace,$myRow);
        $toAdd = $toAdd . $myRow;        
    }



    $myPage=str_replace('%linkrow%',$toAdd,$myPage);
	$myPage=str_replace('%handIn%',json_encode($handIn),$myPage); //setzt Hand In Text ins Modal
    
    echo $myPage;  
?>
