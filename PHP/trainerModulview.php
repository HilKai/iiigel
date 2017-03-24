<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/trainerModulview.html');
	 include_once("database.php");
    

    $currentGroupID = $_GET['groupID'];
    
	 
	 // if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: index.php");
	  exit;
	 }

    if( !$ODB->isTrainerofGroup($_SESSION['user'],$currentGroupID) ) {
	  header("Location: index.php");
	  exit;
	 }
    


    //
    $myGroup = $ODB->getGroupFromID($currentGroupID);
    $myModule = $ODB->getModuleFromID($myGroup->getModulID());
    $search = array('%Gruppenname%', '%Institution%');
    $replace = array($myGroup->getsName(), $ODB->getInstitutionFromID($myGroup-> getInstitutionsID())->getsName());
    $myPage = str_replace($search,$replace,$myPage);

    // select modul member details
    $toAdd = "";


    if ($_POST){
        for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
            if(isset($_POST['levelUp'.$i])){
                if($myGroup->teilnehmer[$i]->getiFortschritt()<sizeof($myModule->chapter)){
                    $id =$myGroup ->teilnehmer[$i]->getID();
                    $ODB->setFortschrittFromUserinGroup($id,$currentGroupID);
                    header("Refresh:0");     
                }
            }
        }
   }
 
    
   for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
        $myRow = file_get_contents('../HTML/trainerModulTablerow.html');
            $search = array('%Prename%', '%Lastname%', '%Progress%', '%ProgressPercent%','%index%');
            $replace = array($myGroup ->teilnehmer[$i]->getsFirstName(), $myGroup ->teilnehmer[$i]->getsLastName(), $myGroup->teilnehmer[$i]->getiFortschritt(), (100*($myGroup->teilnehmer[$i]->getiFortschritt()))/(sizeof($myModule->chapter)),$i);
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
       
    
    }
       
    
    $myPage=str_replace('%Tablerow%',$toAdd,$myPage);

    //create DropDown Chapter List
    $toAdd = ""; //Hinzugefügter HTML Code
   for ($i=0; $i< sizeof($myModule->chapter);$i++){  
            $myRow = file_get_contents('../HTML/ChapterDropdownListItem.html');
            $search = array('%ChapterTitle%');
            $replace = array($myModule ->chapter[$i]->getsTitle());
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
       
       if($_GET){
            if(isset($_GET['levelUpforAll'])){
                $ODB->setFortschrittforallUsersinGroup($myRow,$myGroupID); //--------------------- funktioniert noch nicht :-(
                echo"Test";
            }
        }
       
        
    }
    $myPage=str_replace('%ChapterDropDownItems%',$toAdd,$myPage);
    
    echo $myPage;

    

    
       
    
    
?>