<?php   

 include_once("database.php");
 $currentGroupID = $_GET['groupID'];
 $currentTnID = $_GET['tnID'];


  $handin = $ODB->getHandIn($currentTnID,$currentGroupID);
  echo $handin->getID();
?>