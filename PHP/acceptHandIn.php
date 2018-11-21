<?php   

 include_once("database.php");
 $currentGroupID = $_GET['groupID'];
 $currentTnID = $_GET['tnID'];
 $currentHandInID = $_GET['handinID'];

  $ODB->acceptHandIn($currentTnID,$currentGroupID,$currentHandInID);
  $ODB->setFortschrittFromUserinGroup($currentTnID,$currentGroupID); 
  header("Refresh:0"); 
?>
