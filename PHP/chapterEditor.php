<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/chapterEditor.html');
	 include_once("database.php");
	 include_once("Model/Chapter.php");
    

    $myModuleID = $_GET['moduleID'];
    $myChapterID = $_GET['chapterID'];
	$myChapterID = $myChapterID;
    $myUserID = $_SESSION['user'];
    
	 // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: ../index.php");
        exit;
	 }

    //TODO-Nur user mit Berechtigungen erlaubt

    $myModule = $ODB->getModuleFromID($myModuleID);
    $myUser = $ODB->getUserFromId($myUserID);
    $search = array('%ChapterHeadline%','%ChapterText%','%ChapterID%');
    $chapterText = $ODB->getChapterFromID($myChapterID)->getsText();
    $myPage = str_replace("%ChapterTextRaw%",$chapterText,$myPage);
    $chapterText = $ODB->replaceTags($chapterText);
    $text = '<div class="chapterView col-md-12">  '.$chapterText.'</div>';
    $replace = array($myModule->getChapterHeadlineByIndex($myChapterID),$text,$myChapterID);
    $myPage = str_replace($search,$replace,$myPage);


	$toAdd = "";
	for ($i=0; $i< 5 /*sizeof($ODB->getAllPicsFromModulename($myModule -> getsName()))*/ ;$i++){  
    	$myRow = file_get_contents('../HTML/chapterEditorGalleryPic.html');
		//$search = array('%Link%');
		//$replace = array($ODB->getPicFromID($myModule-> getsName(), $i));
		//$myRow = str_replace($search,$replace,$myRow);
		$toAdd = $toAdd . $myRow;
    }
	$myPage = str_replace('%Pics%',$toAdd,$myPage);
   
    
echo $myPage;
?>
