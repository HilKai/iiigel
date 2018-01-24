<?php
    ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/EditorModulView.html');
	 
     if( !isset($_SESSION['user']) ) {
        header("Location: ../index.php");
        exit;
     }
    
    include_once("database.php");
	include_once("Navigation.php");
    $myModulID = $_GET['modulID'];

    if(!$ODB->hasPermission($_SESSION['user'],"Modul","view",$myModulID) ) {
        echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
	
	
	$myPage = str_replace('%Navigation%',getNavigation(),$myPage);
      $toAdd = "";
	 if (isset($_POST['btn-save']) ) {
		 $newModulName = trim($_POST['modulname']);
		 $newModulName = strip_Tags($newModulName);
		 $newModulName = htmlspecialchars($newModulName);
		 
		if (!empty($newModulName)) {$ODB->setModuleNameFromID($newModulName,$myModulID);};
		 
		 
		 $newModulDescription = trim($_POST['moduldescription']);
		 $newModulDescription = strip_Tags($newModulDescription);
		 $newModulDescription = htmlspecialchars($newModulDescription);
		 
		 $ODB->setModuleDescriptionFromID($newModulDescription,$myModulID);
		 
		 
		 $sortedIdx = trim($_POST['sortedIdx']);
		 $sortedIdx = strip_Tags($sortedIdx);
		 $sortedIdx = htmlspecialchars($sortedIdx);
		 
		 $sortedIdxArray = explode(",", $sortedIdx);
		 for ($x = 0; $x < count($sortedIdxArray); $x++) {
 			$ODB->setChapterIndexFromID($x+1,$sortedIdxArray[$x]);
		 } 
		 
		 
		 
		 $myModul = $ODB->getModuleFromID($myModulID);
	 }
     $myModul = $ODB->getModuleFromID($myModulID);

	 if (isset($_POST['addChapter']) ) {
		 
		 $newChapterName = trim($_POST['chapterName']);
		 $newChapterName = strip_Tags($newChapterName);
		 $newChapterName = htmlspecialchars($newChapterName);
		 
		
		 $ODB->addChaptertoModule($ODB->getHighestIndexFromChapter($myModulID)+1,$newChapterName,"Hallo",$myModulID);
		 
		 $myModul = $ODB->getModuleFromID($myModulID);
	 }


     $modulName =  $myModul->getsName();
     $modulDescription = $myModul->getsDescription();
	 $imagePath = $ODB->getModuleImageFromID($myModulID);
     $search = array('%Modulname%','%ModulText%', '%ModulID%', '%ImagePath%');
     $replace = array($modulName, $modulDescription, $myModulID, $imagePath );

     $myPage=str_replace($search,$replace,$myPage);

     for ($i=0; $i< sizeof($myModul->chapter);$i++){  
            if(($ODB->hasPermission($_SESSION['user'],"Chapter","view",$myModul->chapter[$i]->getID()))
               or ($ODB->hasPermission($_SESSION['user'],"ModulChapter","view",$myModulID))) {
                $myRow = file_get_contents('../HTML/EditorModulViewTablerow.html');
                $search = array('%ChapterNum%', '%ChapterName%', '%modulID%', '%ChapterID%');
                $replace = array($myModul->chapter[$i]->getiIndex(), $myModul->chapter[$i]->getsTitle(),$myModulID,$myModul->chapter[$i]->getID());
                $myRow = str_replace($search,$replace,$myRow);


                $toAdd = $toAdd . $myRow;
            }
     }
     

     $myPage=str_replace('%Tablerow%',$toAdd,$myPage);

    
     echo $myPage;  
    }
      
?>
