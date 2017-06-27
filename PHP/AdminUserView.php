<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/AdminUserView.html');
	 include_once("database.php");
     $allUsers = $ODB->getAllUsers();
	 $searchUsers = $allUsers;

    // if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: ../index.php");
	  exit;
	 }

    if ($_POST){

		if(isset($_POST['search-btn'])){      
            $search = trim($_POST['search']);
			$search = strip_Tags($search);
			$search = htmlspecialchars($search);
			
			$searchUsers = $ODB ->searchUsers($search."%");
			
			var_dump($searchUsers);
        }
        
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

    for ($i=0; $i< sizeof($searchUsers);$i++){   
        $myRow = file_get_contents('../HTML/AdminUserViewTablerow.html');
            $search = array('%Username%', '%Prename%', '%Lastname%', '%Mail%', '%ID%');
            $replace = array($searchUsers[$i]->getsUsername(), $searchUsers[$i]->getsFirstName(), $searchUsers[$i]->getsLastName(), $searchUsers[$i]->getsEMail(), $searchUsers[$i]->getID() );
            $myRow = str_replace($search,$replace,$myRow);
         
        
        $toAdd = $toAdd . $myRow;
       
    
    }


    $myPage=str_replace('%Tablerow%',$toAdd,$myPage);

    
    echo $myPage;  
?>

