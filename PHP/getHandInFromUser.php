<?php   

 include_once("database.php");
 $currentGroupID = $_GET['groupID'];
 $currentTnID = $_GET['tnID'];


  echo $ODB->getHandIn($currentTnID,$currentGroupID) ;
?>