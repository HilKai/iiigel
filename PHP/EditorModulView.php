<?php
    ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/EditorModulView.html');
	 include_once("database.php");
	 $myModulID = $_GET['modulID'];
     $myModul = $ODB->getModuleFromID($myModulID);

     $toAdd = "";
	 var_dump($_POST);
	 if (isset($_POST['btn-save']) ) {
		 $newModulName = trim($_POST['modulname']);
		 $newModulName = strip_Tags($newModulName);
		 $newModulName = htmlspecialchars($newModulName);
		 
		if (!empty($newModulName)) {$ODB->setModuleNameFromID($newModulName,$myModulID);};
		 
		 
		 $newModulDescription = trim($_POST['moduldescription']);
		 $newModulDescription = strip_Tags($newModulDescription);
		 $newModulDescription = htmlspecialchars($newModulDescription);
		 
		 $ODB->setModuleDescriptionFromID($newModulDescription,$myModulID);
		 
		 $myModul = $ODB->getModuleFromID($myModulID);
	 }

	 if (isset($_POST['addChapter']) ) {
		 var_dump($_POST);
		 
		 $myModul = $ODB->getModuleFromID($myModulID);
	 }


     $modulName =  $myModul->getsName();
     $modulDescription = $myModul->getsDescription();
	 $imagePath = $ODB->getModuleImageFromID($myModulID);
var_dump($imagePath);
     $search = array('%Modulname%','%ModulText%', '%ModulID%', '%ImagePath%');
     $replace = array($modulName, $modulDescription, $myModulID, $imagePath );

     $myPage=str_replace($search,$replace,$myPage);

     for ($i=0; $i< sizeof($myModul->chapter);$i++){   
            $myRow = file_get_contents('../HTML/EditorModulViewTablerow.html');
            $search = array('%ChapterNum%', '%ChapterName%', '%modulID%');
            $replace = array($myModul->chapter[$i]->getiIndex(), $myModul->chapter[$i]->getsTitle(),$myModulID);
            $myRow = str_replace($search,$replace,$myRow);
         
        
        $toAdd = $toAdd . $myRow;
     }


     $myPage=str_replace('%Tablerow%',$toAdd,$myPage);

    
     echo $myPage; 
?>