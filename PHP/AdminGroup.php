<?php 
    include_once("database.php");
    $myPage = file_get_contents('../HTML/AdminGroup.html');
  
    
     $toAdd = "";
    $myGroups = $ODB->getAllGroups();
    for ($i=0; $i< sizeof($myGroups);$i++){   
        $myRow = file_get_contents('../HTML/AdminGroupTableRow.html');
        $myTrainer = $ODB->getTrainerofGroup($myGroups[$i]->getID());
        $search = array('%Gruppenbezeichnung%','%Trainer%','%GroupID%');
        if ($myTrainer!=false) {
            $replace = array($myGroups[$i] ->getsName(),$myTrainer->getsFullName(),$myGroups[$i]->getID());    
        } else {
            $replace = array($myGroups[$i] ->getsName(),"-",$myGroups[$i]->getID());
        }
        
        $myRow = str_replace($search,$replace,$myRow);
        
        
        $toAdd = $toAdd . $myRow;
       
       
    }
 
    $myPage = str_replace("%tablerow%",$toAdd,$myPage);     
echo $myPage;
    
?>
