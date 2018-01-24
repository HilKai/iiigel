<?php 
    include_once("database.php");
	include_once("Navigation.php");
session_start();

    $myPage = file_get_contents('../HTML/AdminGroup.html');
  
    if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
		
		
	$myPage = str_replace('%Navigation%',getNavigation(),$myPage);
     $toAdd = "";
    $myGroups = $ODB->getGroupsFromInstitution($_GET['InstitutionsID']);
    for ($i=0; $i< sizeof($myGroups);$i++){   
        $myRow = file_get_contents('../HTML/AdminGroupTableRow.html');
        $myTrainer = $ODB->getTrainerofGroup($myGroups[$i]->getID());
        $search = array('%Gruppenbezeichnung%','%Trainer%','%GroupID%' );
        if ($myTrainer!=false) {
            $replace = array($myGroups[$i] ->getsName(),$myTrainer->getsFullName(),$myGroups[$i]->getID());    
        } else {
            $replace = array($myGroups[$i] ->getsName(),"-",$myGroups[$i]->getID());
        }
        
        $myRow = str_replace($search,$replace,$myRow);
        
        
        $toAdd = $toAdd . $myRow;
       
       
    }

	$add="";
	$myModules = $ODB->getAllModules();
	for ($a=0;$a<sizeof($myModules);$a++){
		$myRow = file_get_contents('../HTML/AdminGroupListItem.html');
        $search = array('%Modulname%','%ModulID%');
		$replace = array($myModules[$a] ->getsName(),$myModules[$a]->getID());   
        $myRow = str_replace($search,$replace,$myRow);
        
        
        $add = $add . $myRow;
	}
 	 $myPage = str_replace("%InstitutionID%",$_GET['InstitutionsID'],$myPage);   

    $myPage = str_replace("%tablerow%",$toAdd,$myPage);   
	$myPage = str_replace("%Listitems%",$add,$myPage);
echo $myPage;
	}
?>
