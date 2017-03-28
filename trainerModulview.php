<?php
     header('Content-type: text/css');
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/trainerModulview.html');
	 include_once("database.php");
	 $grey = "#ddd";
	 $red = "#ff0000";
	 $color = $grey;
    

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
        
        if(isset($_POST['levelUpforAll'])){
            $ODB->setFortschrittforallUsersinGroup($_POST['levelUpforAll'],$currentGroupID); //--------------------- funktioniert noch nicht :-(
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
   }
 
    
   for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
        $myRow = file_get_contents('../HTML/trainerModulTablerow.html');
            $search = array('%Prename%', '%Lastname%', '%Progress%', '%ProgressPercent%','%ID%');
            $replace = array($myGroup ->teilnehmer[$i]->getsFirstName(), $myGroup ->teilnehmer[$i]->getsLastName(), $myGroup->teilnehmer[$i]->getiFortschritt()+1, (100*($myGroup->teilnehmer[$i]->getiFortschritt()))/(sizeof($myModule->chapter)-1),$myGroup->teilnehmer[$i]->getID());
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
       
     
       
        
    }
    $myPage=str_replace('%ChapterDropDownItems%',$toAdd,$myPage);
    
    echo $myPage;  
?>

.notification {
	color: <?=$color?>;
}
					