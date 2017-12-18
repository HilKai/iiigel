<?php   

 include_once("database.php");
 $currentGroupID = $_GET['groupID'];

$myGroup = $ODB->getGroupFromID($currentGroupID);
$myModule = $ODB->getModuleFromID($myGroup->getModulID());

 for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){ 
	 
	 		$progress[$i] = $myGroup->teilnehmer[$i]->getiFortschritt()+1;
	 		$progressPercent[$i] =  (100*($myGroup->teilnehmer[$i]->getiFortschritt()))/(sizeof($myModule->chapter)-1);
  }
echo	json_encode( $progress)."_" .	json_encode($progressPercent);
?>