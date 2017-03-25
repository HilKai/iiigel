<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/ChapterView.html');
	 include_once("database.php");
    

    $myModuleID = $_GET['moduleID'];
    $myChapterID = $_GET['chapterID'];
    $currentGroupID = $_GET['groupID'];

    
	 // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
	 }

    //redirects User if he is not in this group

    if(!$ODB->isUserinGroup($_SESSION['user'],$currentGroupID)){
        header("Location: index.php");
        exit;   
    }




    if ( isset($_POST['NextButton']) ) {
    }

     if ( isset($_POST['AbgabeButton']) ) {
         
    }
    
    //

    $myModule = $ODB->getModuleFromID($myModuleID);
   
    $search = array('%ChapterHeadline%','%ChapterText%');
    $chapterText = $ODB->replaceTags($myModule->getChapterTextbyIndex($myChapterID));
    $text = "<p class='chapterView'> ".$chapterText."</p>";
    $replace = array($myModule->getChapterHeadlineByIndex($myChapterID),$text);
    $myPage = str_replace($search,$replace,$myPage);

   
    $toAdd = "";

    if($myModule->chapter[$myChapterID]->getbIsMandatoryHandIn()) {
        $toAdd = file_get_contents('../HTML/ChapterViewButtonAbgabe.html');
        
    }else{
        $toAdd = file_get_contents('../HTML/ChapterViewButtonNextChapter.html');  
        $search = array('%Link%');
        $iactIndex = $myModule->chapter[$myChapterID]->getiIndex()+1;
        $replace = array("/iiigel/PHP/chapterView.php?moduleID=".$myModuleID."&chapterID=".$iactIndex );
        $toAdd = str_replace($search,$replace,$toAdd); 
    }

    $search = array('%Buttons%');;
    $replace = array($toAdd);
    $myPage = str_replace($search,$replace,$myPage);

    $toAdd = ""; //Hinzugefügter HTML Code
   for ($i=0; $i< sizeof($myModule->chapter);$i++){  
            $myRow = file_get_contents('../HTML/ChapterViewListItem.html');
            $search = array('%ChapterTitle%','%Link%');
            $replace = array($myModule ->chapter[$i]->getsTitle(),"/iiigel/PHP/chapterView.php?moduleID=".$myModuleID."&chapterID=".$i."&groupID=".$currentGroupID );
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
    }
    $myPage=str_replace('%ChapterDropDownItems%',$toAdd,$myPage);
    
    echo $myPage;
?>
