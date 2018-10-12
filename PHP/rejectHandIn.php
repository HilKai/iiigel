<?php   

 include_once("database.php");
 $currentGroupID = $_GET['groupID'];
 $currentTnID = $_GET['tnID'];
 $currentHandInID = $_GET['handinID'];

  $ODB-> rejectHandIn($currentTnID,$currentGroupID,$currentHandInID) ; 
  header("Refresh:0"); 
?>