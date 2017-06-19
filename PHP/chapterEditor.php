<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/chapterEditor.html');
	 include_once("database.php");
    

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


  
    
    //

    $myModule = $ODB->getModuleFromID($myModuleID);
    $myUser = $ODB->getUserFromId($myUserID);
    $search = array('%ChapterHeadline%','%ChapterText%','%ChapterID%');
    $chapterText = $ODB->getChapterFromID($myChapterID)->getsText();
    $myPage = str_replace("%ChapterTextRaw%",$chapterText,$myPage);
    $chapterText = $ODB->replaceTags($chapterText);
    $text = '<div class="chapterView col-md-12">  '.$chapterText.'</div>';
    $replace = array($myModule->getChapterHeadlineByIndex($myChapterID),$text,$myChapterID);
    $myPage = str_replace($search,$replace,$myPage);
   
    
echo $myPage;
?>
