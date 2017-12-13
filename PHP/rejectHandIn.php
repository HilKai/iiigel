<?php   

 include_once("database.php");
 $currentGroupID = $_GET['groupID'];
 $currentTnID = $_GET['tnID'];


  $ODB-> rejectHandIn($currentTnID,$currentGroupID) ; 
echo "jaj";
  header("Refresh:0"); 
?>