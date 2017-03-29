<?php   

 include_once("database.php");

 $currentGroup = $ODB->getGroupFromID($ID);

  foreach ($currentGroup->teilnehmer as $tn) {
      if ($ODB->isNewHandIn($tn,$currentGroup->getID())) echo $tn->getID()."," ;
  }  
    
?>