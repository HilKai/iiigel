<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/AdminUserView.html');
	 include_once("database.php");
     $allUsers = $ODB->getAllUsers();

    // if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: ../index.php");
	  exit;
	 }

    if ($_POST){

        if(isset($_POST['DeleteUser'])){      
                 for ($i=0; $i< sizeof($allUsers);$i++){  
                    if($allUsers[$i]->getID() ==  $_POST['DeleteUser']) {
                        $ODB->deleteUser($allUsers[$i]->getID());
                        header("Refresh:0");     
                    }
                }
        }
    }

    $toAdd = "";

    for ($i=0; $i< sizeof($allUsers);$i++){   
        $myRow = file_get_contents('../HTML/AdminUserViewTablerow.html');
            $search = array('%Username%', '%Prename%', '%Lastname%', '%Mail%', '%ID%');
            $replace = array($allUsers[$i]->getsUsername(), $allUsers[$i]->getsFirstName(), $allUsers[$i]->getsLastName(), $allUsers[$i]->getsEMail(), $allUsers[$i]->getID() );
            $myRow = str_replace($search,$replace,$myRow);
         
        
        $toAdd = $toAdd . $myRow;
       
    
    }


    $myPage=str_replace('%Tablerow%',$toAdd,$myPage);

    
    echo $myPage;  
?>

