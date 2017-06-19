<?php
    ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/EditorModulView.html');
	 include_once("database.php");
	 $myModulID = $_GET['modulID'];

     $toAdd = "";
	 //var_dump($_POST);
	 if (isset($_POST['btn-save']) ) {
		 $newModulName = trim($_POST['modulname']);
		 $newModulName = strip_Tags($newModulName);
		 $newModulName = htmlspecialchars($newModulName);
		 
		if (!empty($newModulName)) {$ODB->setModuleNameFromID($newModulName,$myModulID);};
		 
		 
		 $newModulDescription = trim($_POST['moduldescription']);
		 $newModulDescription = strip_Tags($newModulDescription);
		 $newModulDescription = htmlspecialchars($newModulDescription);
		 
		 $ODB->setModuleDescriptionFromID($newModulDescription,$myModulID);
	 }
     $myModul = $ODB->getModuleFromID($myModulID);

     $modulName =  $myModul->getsName();
     $modulDescription = $myModul->getsDescription();
     $search = array('%Modulname%','%ModulText%', '%ModulID%');
     $replace = array($modulName, $modulDescription, $myModulID);

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