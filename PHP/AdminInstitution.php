<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/AdminInstitution.html');
	 include_once("database.php");
	include_once("Navigation.php");
   
    $myUserID = $_SESSION['user'];
    
	 // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: ../index.php");
        exit;
	 }

	if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
	
	$myPage = str_replace('%Navigation%',getNavigation(),$myPage);
    $toAdd = "";
    $myInstitution = $ODB->getAllInstitutions();
    for ($i=0; $i< sizeof($myInstitution);$i++){   
        $myRow = file_get_contents('../HTML/AdminInstitutionTablerow.html');
        $search = array('%Institutionsname%','%InstitutionsID%');
        $replace = array($myInstitution[$i] ->getsName(),$myInstitution[$i]->getID());
        $myRow = str_replace($search,$replace,$myRow);
        
        
        $toAdd = $toAdd . $myRow;
       
       
    }

   
   

    

    $myPage = str_replace("%tablerow%",$toAdd,$myPage);     
echo $myPage;
	}
?>
