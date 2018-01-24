<?php 
    include_once("database.php");
	include_once("Navigation.php");
    session_start();

    $myPage = file_get_contents('../HTML/InstitutionDetailView.html');
  
    $myRow = file_get_contents('../HTML/InstitutionDetailView.html');
    $search = array('%Institutionsname%','%InstitutionsID%');
    $replace = array($ODB->getInstitutionFromID($_GET['InstitutionsID'])->getsName(),$_GET['InstitutionsID']) ;
    $myPage = str_replace($search,$replace,$myRow);
  

	if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
	
	$myPage = str_replace('%Navigation%',getNavigation(),$myPage);
     $toAdd = "";
    $myUsers = $ODB->getUsersFromInstitution($_GET['InstitutionsID']);
    for ($i=0; $i< sizeof($myUsers);$i++){   
        $myRow = file_get_contents('../HTML/InstitutionDetailViewTablerow.html');
        $search = array('%Vorname%','%Nachname%','%Username%','%Email%');
        $replace = array($myUsers[$i] ->getsFirstName(),$myUsers[$i]->getsLastName(),$myUsers[$i]->getsUsername(),$myUsers[$i]->getsEMail());
        $myRow = str_replace($search,$replace,$myRow);
        
        
        $toAdd = $toAdd . $myRow;
       
       
    }
    
    $add = '';
    $myUsers= $ODB->GetAllUsersNotInInstitution($_GET['InstitutionsID']);

	for ($a=0;$a<sizeof($myUsers);$a++){
		$myRow = file_get_contents('../HTML/AdminGroupUserListitem.html');
      
        $search = array('%Vorname%','%Nachname%','%UserID%');
		$replace = array($myUsers[$a]->getsFirstName(),$myUsers[$a]->getsLastName(),$myUsers[$a]->getID());  
        $myRow = str_replace($search,$replace,$myRow);
        $add = $add . $myRow;
       
	}

    $myPage = str_replace("%Listitems%",$add,$myPage);   
    
    $myPage = str_replace("%tablerow%",$toAdd,$myPage);     
    echo $myPage;
	}
?>
