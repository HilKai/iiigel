<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/ChapterView.html');
	 include_once("database.php");

	 // if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: index.php");
	  exit;
	 }


    // this script may be called by routing.php, make sure to use get-params only when not already set
    if (!isset($oModule)){
        $iModuleId = $_GET['moduleID'];
        $oModule = $ODB->getModuleFromID($iModuleId);
    }
    if (!isset($iChapterIndex)){
        $iChapterIndex = $_GET['chapterID'];
    }
    $search = array('%ChapterHeadline%','%ChapterText%');
    $replace = array($oModule->getChapterHeadlineByIndex($iChapterIndex),$ODB->replaceTags($oModule->getChapterTextbyIndex($iChapterIndex)));
    $myPage = str_replace($search,$replace,$myPage);


    $toAdd = ""; //Hinzugefügter HTML Code
   for ($i=0; $i< sizeof($oModule->chapter); $i++){
            $myRow = file_get_contents('../HTML/ChapterViewListItem.html');
            $search = array('%ChapterTitle%','%Link%');
            $replace = array($oModule ->chapter[$i]->getsTitle(),"/iiigel/PHP/chapterView.php?moduleID=".$iModuleId."&chapterID=".$i."" );
            $myRow = str_replace($search,$replace,$myRow);

        $toAdd = $toAdd . $myRow;
    }
    $myPage=str_replace('%ChapterDropDownItems%',$toAdd,$myPage);

    echo $myPage;
?>