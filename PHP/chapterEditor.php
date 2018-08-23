<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/chapterEditor.html');
	 include_once("database.php");
	 include_once("Model/Chapter.php");
	 include_once("Navigation.php");
    

    $myModuleID = $_GET['moduleID'];
    $myChapterID = $_GET['chapterID'];
	$myChapterID = $myChapterID;
    $myUserID = $_SESSION['user'];
    
	 // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: ../index.php");
        exit;
	 }
    if (isset($_GET['openmodal'])){
        $bool = "true";
    } else {
        $bool = "false";
    }

	
	$myPage = str_replace('%Navigation%',getNavigation(),$myPage);
	
	if(!($ODB->hasPermission($_SESSION['user'],"Chapter","edit",$myChapterID)and ($ODB->hasPermission($_SESSION['user'],"Chapter","edit",$myChapterID))) ) {
        echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
    //TODO-Nur user mit Berechtigungen erlaubt
    $myModule = $ODB->getModuleFromID($myModuleID);
    $myUser = $ODB->getUserFromId($myUserID);
    $search = array('%ChapterHeadline%','%ChapterText%','%ChapterID%','%ModuleID%','%bool%');
    $chapterText = $ODB->getChapterFromID($myChapterID)->getsText();
    $myPage = str_replace("%ChapterTextRaw%",$chapterText,$myPage);
    $chapterText = $ODB->replaceTags($chapterText);
    $text = '<div class="chapterView col-md-12">  '.$chapterText.'</div>';
    $replace = array($myModule->getChapterHeadlineByIndex($myChapterID),$text,$myChapterID,$myModuleID,$bool);
    $myPage = str_replace($search,$replace,$myPage);


	$toAdd = "";
    $images =$ODB->getAllPicsFromModuleID($myModule -> getID()); 

	for ($i=0; $i< sizeof($images) ;$i++){  
     
        $myRow = file_get_contents('../HTML/chapterEditorGalleryPic.html');
		$myRow = str_replace("%Link%",$images[$i],$myRow);
		$toAdd = $toAdd . $myRow;
    }
	$myPage = str_replace('%Pics%',$toAdd,$myPage);
   
    
echo $myPage;
	}
	
?>
