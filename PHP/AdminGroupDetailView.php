<?php 
    include_once("database.php");
    $myPage = file_get_contents('../HTML/AdminGroupDetailView.html');
  
    $myRow = file_get_contents('../HTML/AdminGroupDetailView.html');
    $search = array('% %');
    $replace = array($ODB->getGroupFromID($_GET['GroupID']) ->getsName());
    $myPage = str_replace($search,$replace,$myRow);
  
      
     $toAdd = "";
    $myUsers = $ODB->getUsersFromGroup();
    for ($i=0; $i< sizeof($myUsers);$i++){   
        $myRow = file_get_contents('../HTML/AdminGroupDetailTableRow.html');
        $search = array('%Vorname%','%Nachname%','%Username%','%Email%');
        $replace = array($myUsers[$i] ->getsFirstName(),$myUsers[$i]->getsLastName(),$myUsers[$i]->getsUsername(),$myUsers[$i]->getsEMail());
        $myRow = str_replace($search,$replace,$myRow); 
        
        
        $toAdd = $toAdd . $myRow;
       
       
    }
 
    $myPage = str_replace("%tablerow%",$toAdd,$myPage);     
echo $myPage;
    
?>
