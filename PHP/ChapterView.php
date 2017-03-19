<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/ChapterView.html');
	 include_once("database.php");
    

    $myModuleID = 1;
    $myChapterID = 1;

	 
	 // if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: index.php");
	  exit;
	 }
    
    //

    $myModule = $ODB->getModuleFromID($myModuleID);
    $search = array('%ChapterHeadline%','ChapterText');
    $replace = array($myModule->getChapterHeadlineByIndex($myChapterID),$myModule->getChapterTextbyIndex($myChapterID));
    $myPage = str_replace($search,$replace,$myPage);


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