<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/ChapterView.html');
	 include_once("database.php");
	include_once("Navigation.php");
    
	
    $myModuleID = $_GET['moduleID'];
    $myModule = $ODB->getModuleFromID($myModuleID);
    $myChapterID = $_GET['chapterID'];

	$myModule = $ODB->getModuleFromID($myModuleID);
	$myChapterIDp = $_GET['chapterID']+1;
    $myUserID = $_SESSION['user'];
    $currentGroupID = $_GET['groupID'];
    
	$myPage = str_replace('%Navigation%',getNavigation(),$myPage);//AL Setzt die Navigationsleiste zusammen

if(!($ODB->hasPermission($_SESSION['user'],"Chapter","view",$myModule->chapter[$myChapterID]->getID())or($ODB->hasPermission($_SESSION['user'],"ModulChapter","view",$myModuleID)))) {//AL Wenn der Nutzer Teil des Projektes ist
       echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
       exit;
    }else {

    $myUserID = $_SESSION['user'];
    $currentGroupID = $_GET['groupID'];
    

	 // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: ../index.php");
        exit;
	 }



    //redirects User if he is not in this group

    if(!$ODB->isUserinGroup($_SESSION['user'],$currentGroupID)){
     //   header("Location:  ../index.php");
      //  exit;   
    }


  
    
    //

    $myModule = $ODB->getModuleFromID($myModuleID);
    $myUser = $ODB->getUserFromId($myUserID);
    $myGroups = $ODB->getGroupsFromUserID($_SESSION['user']);
    $activeGroup = $ODB->getGroupFromID($currentGroupID);
    $currentProgress =$activeGroup->getProgressFromUserID($_SESSION['user']);
   
    if ( isset($_POST['NextButton']) ) {//AL Wenn auf den 'nächstes Kapitel' Button gedrückt wird
       
 
        if ($currentProgress  == $myChapterID){ //Überprüft ob der User genau in diesem Chapter ist
            $ODB->setFortschrittFromUserinGroup($myUserID,$currentGroupID);     
        }
       header("Location: ../PHP/ChapterView.php?moduleID=".$myModuleID."&chapterID=". ($myChapterID+1)."&groupID=".$currentGroupID );//Bringe den Nutzer ins nächste Kapitel
    }

    if ( isset($_POST['AbgabeButton'])){//AL Wenn auf den 'Abgabe' Button gedrückt wird
        $ODB->addHandIn($myUserID,$activeGroup->getID(),$myChapterIDp,$_POST['modalData']); //AL In der Datenbank wird ein neues HandIn erstellt
    }
    if ( isset($_POST['EditChapterButton'])){//AL Wenn der Trainer auf den Button für das bearbeiten dieses Kapitels drückt
        header("Location: ../PHP/chapterEditor.php?moduleID=".$myModuleID."&chapterID=".($myChapterID+1));
    }
    //if(($ODB->isTrainerofGroup($myUserID,$currentGroupID)) and (($GLOBALS["ODB"]->isAdmin($_SESSION['user'])))) { AL UNBENUTZT

    if($ODB->isTrainerofGroup($myUserID,$currentGroupID)) {
        $toAdd = file_get_contents('../HTML/ChapterViewTrainerChapterToggle.html');//AL erstellt den Trainer Button
        $search = array('%Toggle%');
        $replace = array($toAdd);
        $myPage = str_replace($search,$replace,$myPage);
        
        $toAdd = file_get_contents('../HTML/ChapterViewEditorChapterToggle.html');//AL erstellt den 'Dieses Kapitel bearbeiten' Button
        $search = array('%Toggle2%');
        $replace = array($toAdd);
        $myPage = str_replace($search,$replace,$myPage);
    }else {//AL Erstelle keine Buttons
        $toAdd = "";
        $search = array('%Toggle%');
        $replace = array($toAdd);
        $myPage = str_replace($search,$replace,$myPage); 
        
        $toAdd = "";
        $search = array('%Toggle2%');
        $replace = array($toAdd);
        $myPage = str_replace($search,$replace,$myPage);
    }
    

  
        $link = "../PHP/trainerModulview.php?groupID=".$currentGroupID;//AL Legt den Link fest, auf den man weitergeleitet wird, wenn man auf den Trainerbutton klickt(%TogglelinkT% ist das href Attribut)
        $search = array('%TogglelinkT%');
        $replace = array($link);
        $myPage = str_replace($search,$replace,$myPage); 
   //AL Setze das Chapter zusammen
    $search = array('%ChapterHeadline%','%ChapterText%','%editlink%');
    $chapterText = $ODB->replaceTags($myModule->getChapterTextbyIndex($myChapterID));
    $text = '<div class="chapterView col-md-12">  '.$chapterText.' </div>';
    $replace = array($myModule->getChapterHeadlineByIndex($myChapterID),$text,"chapterEditor.php?moduleID=".$myModuleID."&chapterID=".$myChapterIDp);
    $myPage = str_replace($search,$replace,$myPage);
   
   
    $toAdd = ""; //hinzugefügter HTML Code

    if(($myModule->chapter[$myChapterID]->getbIsMandatoryHandIn()) && ($currentProgress <= $myChapterID)) {//AL Wenn das Kapitel eine Abgabe verlangt
        $toAdd = file_get_contents('../HTML/ChapterViewButtonAbgabe.html');//AL Platziere den Abgabebutton
    }else{
        if (sizeof($myModule->chapter) > $myChapterID +1 ){
            $toAdd =  file_get_contents('../HTML/ChapterViewButtonNextChapter.html');  //AL Platziere den Nächstes Kapitel Button
            $search = array('%Link%');
            $iactIndex = $myModule->chapter[$myChapterID]->getiIndex();
            $replace = array("../PHP/ChapterView.php?moduleID=".$myModuleID."&chapterID=".$iactIndex."&groupID=".$currentGroupID);
            $toAdd = str_replace($search,$replace,$toAdd); 
        }
    }

   

    $search = array('%Buttons%');
    $replace = array($toAdd);
    $myPage = str_replace($search,$replace,$myPage);
    $ProgressPercent= 0;
    if ($ODB->isTrainerofGroup($myUserID,$currentGroupID)) {//AL Wenn man Trainer ist, sieht man den DUrschnittlichen Fortschritt der Gruppe
        $Progress=($activeGroup->getAverageProgressFromGroup())/sizeof($myModule->chapter);
        $ProgressPercent= 100*(($activeGroup->getAverageProgressFromGroup())/sizeof($myModule->chapter));
    } else {//AL Sonst sieht man seinen eigenen Fortschritt
        $Progress= $currentProgress;
        $ProgressPercent=100*(($currentProgress)/(sizeof ($myModule->chapter)));
    }
   $search = array( '%Progress%', '%ProgressPercent%');//AL Aktualisiere die Progressbar
   $replace = array($Progress,$ProgressPercent);
   $myPage = str_replace($search,$replace,$myPage);

    $toAdd = "";
    for ($i=0; $i< sizeof($myModule->chapter);$i++){  //Die Progressbar passt ihre Farbe an den Fortschritt an
            $myRow = file_get_contents('../HTML/ChapterViewListItem.html');
            $search = array('%ChapterTitle%','%Link%','%style%');
            if ($i < $currentProgress){
                  $style =  'background-color:#fdfdfd;';
               
            } else {
                if ($i == $currentProgress){
                     $style = 'background-color:#bcd2ee;';    
                } else {
                    $style = 'background-color:#dedede;' ;      
                }
            }
            if ($i == $myChapterID){
                $style = 'background-color:#bcd2ee;';  
            }
            $style= $style."width:250px;height:35px;border:0px";
            $replace = array($myModule ->chapter[$i]->getsTitle(),"../PHP/ChapterView.php?moduleID=".$myModuleID."&chapterID=".$i."&groupID=".$currentGroupID,$style );
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
    }
    $myPage=str_replace('%ChapterDropDownItems%',$toAdd,$myPage);
    
echo $myPage;
	

}
?>
