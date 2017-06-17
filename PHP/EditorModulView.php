<?php
    ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/EditorModulView.html');
	 include_once("database.php");
	 $myModulID = 1;
     $myModul = $ODB->getModuleFromID($myModulID);

     $toAdd = "";
	var_dump($_POST);
	 if (isset($_POST['btn-save']) ) {
		 $newModulName = trim($_POST['modulname']);
		 $newModulName = strip_Tags($newModulName);
		 $newModulName = htmlspecialchars($newModulName);
		 
		 //if (!empty($newModulName)) {$ODB->setModulNameFromID($newModulName,$myModulID);};
		 
		 
		 $newModulDescription = trim($_POST['moduldescription']);
		 $newModulDescription = strip_Tags($newModulDescription);
		 $newModulDescription = htmlspecialchars($newModulDescription);
		 
		 //$ODB->setModulDescriptionFromID($newModulDescription,$myModulID);
	 }

     $modulName =  $myModul->getsName();
     $modulDescription = $myModul->getsDescription();
     $search = array('%Modulname%','%ModulText%');
     $replace = array($modulName, $modulDescription);

     $myPage=str_replace($search,$replace,$myPage);

     for ($i=0; $i< sizeof($myModul->chapter);$i++){   
            $myRow = file_get_contents('../HTML/EditorModulViewTablerow.html');
            $search = array('%ChapterNum%', '%ChapterName%');
            $replace = array($myModul->chapter[$i]->getiIndex(), $myModul->chapter[$i]->getsTitle());
            $myRow = str_replace($search,$replace,$myRow);
         
        
        $toAdd = $toAdd . $myRow;
     }


     $myPage=str_replace('%Tablerow%',$toAdd,$myPage);

    
     echo $myPage; 
?>