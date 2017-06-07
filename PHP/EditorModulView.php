<?php
    ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/EditorModulView.html');
	 include_once("database.php");
     $myModul = $ODB->getModuleFromID(1);

     $toAdd = "";

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