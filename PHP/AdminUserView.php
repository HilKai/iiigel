<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/AdminUserView.html');
	 include_once("database.php");

    // if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: ../index.php");
	  exit;
	 }

    $toAdd = "";

    for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
        $myRow = file_get_contents('../HTML/AdminUserViewTablerow.html');
            $search = array('%Prename%', '%Lastname%', '%Mail%', '%Institution%');
            $replace = array($myGroup ->teilnehmer[$i]->getsFirstName(), $myGroup ->teilnehmer[$i]->getsLastName(), , );
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
       
    
    }


    $myPage=str_replace('%Tablerow%',$toAdd,$myPage);

    
    echo $myPage;  
?>

