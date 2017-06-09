<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/AdminInstitution.html');
	 include_once("database.php");
   
    $myUserID = $_SESSION['user'];
    
	 // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: ../index.php");
        exit;
	 }
    $toAdd = "";
    $myInstitution = $ODB->getAllInstitutions();
    for ($i=0; $i< sizeof($myInstitution);$i++){   
        $myRow = file_get_contents('../HTML/AdminInstitutionTablerow.html');
            $search = array('%Institutionsname%');
            $replace = array($myInstitution[$i] ->getsName());
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
       
    
    }

    $myPage = str_replace("%tablerow%",$toAdd,$myPage);     
echo $myPage;
?>
