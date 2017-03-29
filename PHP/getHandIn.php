<?php   

 include_once("database.php");
 $currentGroupID = $_GET['groupID'];
 $currentGroup = $ODB->getGroupFromID($currentGroupID);

  foreach ($currentGroup->teilnehmer as $tn) {
      if ($ODB->isNewHandIn($tn->getID(),$currentGroup->getID())) echo $tn->getID() ;
  }  
    
?>