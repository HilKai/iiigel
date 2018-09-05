<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/trainerModulview.html');
	 include_once("database.php");
	 include_once("Navigation.php");
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
    
    $myGroup = $ODB->getGroupFromID($currentGroupID);
    $myModule = $ODB->getModuleFromID($myGroup->getModulID());
    $search = array('%Gruppenname%', '%Institution%','%GroupID%');
    $replace = array($myGroup->getsName(), $ODB->getInstitutionFromID($myGroup-> getInstitutionsID())->getsName(), $currentGroupID);
    $myPage = str_replace($search,$replace,$myPage);
	
	$myPage = str_replace('%Navigation%',getNavigation(),$myPage);
    // select modul member details
    

    $myModuleID = $myModule->getID();

	$toAdd = "";

    if ($_POST){
        
		//Alle TN auf 1 Level setzten
        if(isset($_POST['levelUpforAll'])){
            $ODB->setFortschrittforallUsersinGroup($_POST['levelUpforAll'],$currentGroupID);
            header("Refresh:0");   
        }
		
		//1 Level hochsetzten
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
        
		//HandIn akzeptieren
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
		
		//HandIn ablehnen
		if(isset($_POST['rejectHandIn'])){
            for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
                if($myGroup->teilnehmer[$i]->getID() ==  $_POST['rejectHandIn']) {
                        $id =$myGroup ->teilnehmer[$i]->getID();
                        $ODB->rejectHandIn($id,$currentGroupID);
                        header("Refresh:0");     
                }
            }
            
        }
        
   }


   //Tabellenreihen erstelllen & mit Inhalt füllem
   for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){ //Durchläuft alle TN in Gruppe
	   		$handIn[$myGroup->teilnehmer[$i]->getID()] = $ODB->getHandIn($myGroup->teilnehmer[$i]->getID(), $myGroup->getID()); //HandIn vom User
        	$myRow = file_get_contents('../HTML/trainerModulTablerow.html'); //Tabellenreihe in externer HTML Datei
            $search = array('%Prename%', '%Lastname%', '%Progress%', '%ProgressPercent%','%ID%'); //Platzhalter die ersetzt werden sollen
            $replace = array($myGroup ->teilnehmer[$i]->getsFirstName(), $myGroup ->teilnehmer[$i]->getsLastName(), $myGroup->teilnehmer[$i]->getiFortschritt()+1, (100*($myGroup->teilnehmer[$i]->getiFortschritt()))/(sizeof($myModule->chapter)-1),$myGroup->teilnehmer[$i]->getID()); //Bekommt richtige Werte aus der Datenbank
            $myRow = str_replace($search,$replace,$myRow); //In Tabellenreihe werden Platzhalter 
        
        	$toAdd = $toAdd . $myRow; //neue Tabellenreihe hinzufügen
    }
	$myPage=str_replace('%Tablerow%',$toAdd,$myPage); //Tabelle wird mit Reihen gefüllt


	//Link setzen im Toggle Button
	$link = "../PHP/ChapterView.php?moduleID=".$myModuleID."&chapterID=0&groupID=".$currentGroupID;
	$search = array('%TogglelinkK%');
	$replace = array($link);
	$myPage = str_replace($search,$replace,$myPage); 


   //Dropdownliste mit allen Kapiteln (fül alle TN auf 1 Kapitel)
   $toAdd = ""; 
   for ($i=0; $i< sizeof($myModule->chapter);$i++){  
            $myRow = file_get_contents('../HTML/ChapterDropdownListItem.html');
            $search = array('%ChapterTitle%');
            $replace = array($myModule ->chapter[$i]->getsTitle());
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
       
     
       
        
    }
    $myPage=str_replace('%ChapterDropDownItems%',$toAdd,$myPage);

	//Alle aktiven Einladungslinks in Tabelle
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

	//alle TN für Dropdown
	$add = '';
    $myUsers= $ODB->getAllUsersFromInstitutionNotInGroup($myGroup->getInstitutionsID(),intval($_GET['groupID']));
	for ($a=0;$a<sizeof($myUsers);$a++){
		$myRow = file_get_contents('../HTML/AdminGroupUserListitem.html');
      
        $search = array('%Vorname%','%Nachname%','%UserID%');
		$replace = array($myUsers[$a]->getsFirstName(),$myUsers[$a]->getsLastName(),$myUsers[$a]->getID());  
        $myRow = str_replace($search,$replace,$myRow);
        $add = $add . $myRow;
       
	}
    $myPage = str_replace("%allTN%",$add,$myPage);  //alle TN in Dropdown


	//HandIns auf Seite anzeigen
	$myPage=str_replace('%handIn%',json_encode($handIn),$myPage); //setzt Hand In Text ins Modal


	//TN Hinzufügen
    if (isset($_POST['HinzuButton'])){ 
        $ODB->addUsertoGroup($_POST['UserID'],$currentGroupID);
        header ("Location: ../PHP/trainerModulview.php?groupID=".$currentGroupID);
    }
    
	//Einladungslink erstellen
    if (isset($_POST['ErstellButton'])){
        $ODB->addGroupInvitationLink($_POST['input'],$currentGroupID,$_POST['start'],$_POST['end']);
        header("Location: ../PHP/trainerModulview.php?groupID=".$currentGroupID);
    }
    
    echo $myPage;  
?>
