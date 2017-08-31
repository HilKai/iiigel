<?php 
    include_once("database.php");
    $myPage = file_get_contents('../HTML/AdminGroupDetailView.html');
  
    $myRow = file_get_contents('../HTML/AdminGroupDetailView.html');
    $search = array('% %');
    $replace = array($ODB->getGroupFromID($_GET['GroupID']) ->getsName());
    $myPage = str_replace($search,$replace,$myRow);
    $currentGroup = $ODB->getGroupFromID($_GET['GroupID']);
      
     $toAdd = "";
    $myUsers = $ODB->getUsersFromGroup($_GET['GroupID']);
    for ($i=0; $i< sizeof($myUsers);$i++){   
        $myRow = file_get_contents('../HTML/AdminGroupDetailTableRow.html');
        $search = array('%Vorname%','%Nachname%','%Username%','%Email%');
        $replace = array($myUsers[$i] ->getsFirstName(),$myUsers[$i]->getsLastName(),$myUsers[$i]->getsUsername(),$myUsers[$i]->getsEMail());
        $myRow = str_replace($search,$replace,$myRow); 
        
        
        $toAdd = $toAdd . $myRow;
       
       
    }
    $add = '';
   $myUsers= $ODB->getUsersFromInstitution($currentGroup->getInstitutionsID());

	for ($a=0;$a<sizeof($myUsers);$a++){
		$myRow = file_get_contents('../HTML/AdminGroupUserListitem.html');
      
        $search = array('%Vorname%','%Nachname%','%UserID%');
		$replace = array($myUsers[$a]->getsFirstName(),$myUsers[$a]->getsLastName(),$myUsers[$a]->getID());  
        $myRow = str_replace($search,$replace,$myRow);
        $add = $add . $myRow;
       
	}

    $myPage = str_replace("%Listitems%",$add,$myPage);   
    $myPage = str_replace("%GroupID%",$_GET['GroupID'],$myPage);   
    $myPage = str_replace("%Gruppenname%",$currentGroup->getsName(),$myPage);  
    $myPage = str_replace("%tablerow%",$toAdd,$myPage);     
    echo $myPage;
    
?>
