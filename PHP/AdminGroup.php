<?php 
    include_once("database.php");
    $myPage = file_get_contents('../HTML/AdminGroup.html');
  
    
     $toAdd = "";
    $myGroups = $ODB->getAllGroups();
    for ($i=0; $i< sizeof($myGroups);$i++){   
        $myRow = file_get_contents('../HTML/AdminGroupTableRow.html');
        $myTrainer = $ODB->getTrainerofGroup($myGroups[$i]->getID());
        $search = array('%Gruppenbezeichnung%','%Trainer%');
        if ($myTrainer!=false) {
            $replace = array($myGroups[$i] ->getsName(),$myTrainer->getsFullName());    
        } else {
            $replace = array($myGroups[$i] ->getsName(),"-");
        }
        
        $myRow = str_replace($search,$replace,$myRow);
        
        
        $toAdd = $toAdd . $myRow;
       
       
    }
 
    $myPage = str_replace("%tablerow%",$toAdd,$myPage);     
echo $myPage;
    
?>
