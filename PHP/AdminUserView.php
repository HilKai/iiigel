<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/AdminUserView.html');
	 include_once("database.php");
	include_once("Navigation.php");

     $allUsers = $ODB->getAllUsers();
	 $searchUsers = $allUsers;
	 $userSearch = "";

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
    if ($_POST){

		if(isset($_POST['search-btn'])){      
            $userSearch = trim($_POST['search']);
			$userSearch = strip_Tags($userSearch);
			$userSearch = htmlspecialchars($userSearch);
			
			$searchUsers = $ODB ->searchUsers("%".$userSearch."%");
		
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
	$myPage = str_replace('%lastSearch%',$userSearch,$myPage);

    for ($i=0; $i< sizeof($searchUsers);$i++){   
        $myRow = file_get_contents('../HTML/AdminUserViewTablerow.html');
            $search = array('%Username%', '%Prename%', '%Lastname%', '%Mail%', '%ID%');
            $replace = array($searchUsers[$i]->getsUsername(), $searchUsers[$i]->getsFirstName(), $searchUsers[$i]->getsLastName(), $searchUsers[$i]->getsEMail(), $searchUsers[$i]->getID() );
            $myRow = str_replace($search,$replace,$myRow);
         
        
        $toAdd = $toAdd . $myRow;
       
    
    }


    $myPage=str_replace('%Tablerow%',$toAdd,$myPage);

    
    echo $myPage;  
	}
?>
