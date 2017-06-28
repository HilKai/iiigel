<?php 
    include_once("database.php");
    $myPage = file_get_contents('../HTML/InstitutionDetailView.html');
  
    $myRow = file_get_contents('../HTML/InstitutionDetailView.html');
    $search = array('%Institutionsname%');
    $replace = array($ODB->getInstitutionFromID($_GET['InstitutionsID']) ->getsName());
    $myPage = str_replace($search,$replace,$myRow);
  
      
     $toAdd = "";
    $myUsers = $ODB->getAllUsers();
    for ($i=0; $i< sizeof($myUsers);$i++){   
        $myRow = file_get_contents('../HTML/InstitutionDetailViewTablerow.html');
        $search = array('%Vorname%','%Nachname%','%Username%','%Email%');
        $replace = array($myUsers[$i] ->getsFirstName(),$myUsers[$i]->getsLastName(),$myUsers[$i]->getsUsername(),$myUsers[$i]->getsEMail());
        $myRow = str_replace($search,$replace,$myRow);
        
        
        $toAdd = $toAdd . $myRow;
       
       
    }
 
    $myPage = str_replace("%tablerow%",$toAdd,$myPage);     
echo $myPage;
    
?>
