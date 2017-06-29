<?php 
    include_once("database.php");
    $myPage = file_get_contents('../HTML/AdminGroup.html');
  
    
     $toAdd = "";
    $myGroups = $ODB->getAllGroups();
    for ($i=0; $i< sizeof($myGroups);$i++){   
        $myRow = file_get_contents('../HTML/AdminGroupTableRow.html');
        $search = array('%Gruppenbezeichnung%','%Trainer%');
        $replace = array($myGroups[$i] ->getsName(),$myGroups[$i] ->getTrainer());
        $myRow = str_replace($search,$replace,$myRow);
        
        
        $toAdd = $toAdd . $myRow;
       
       
    }
 
    $myPage = str_replace("%tablerow%",$toAdd,$myPage);     
echo $myPage;
    
?>
