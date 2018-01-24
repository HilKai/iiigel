<?php 
    include_once("database.php");
	include_once("Navigation.php");
session_start();
    $myPage = file_get_contents('../HTML/AdminModulDetailView.html');
  
    if(!$ODB->isAdmin($_SESSION['user'])) {
		 echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {
	
	$myPage = str_replace('%Navigation%',getNavigation(),$myPage);
     $toAdd = "";
    $myModules = $ODB->getAllModules();
    for ($i=0; $i< sizeof($myModules);$i++){   
        $myRow = file_get_contents('../HTML/ModulDetailTablerow.html');
        $search = array('%Modulbezeichnung%','%Sprache%');
        $replace = array($myModules[$i] ->getsName(),$myModules[$i]->getsLanguage());
        $myRow = str_replace($search,$replace,$myRow);
        
        
        $toAdd = $toAdd . $myRow;
       
       
    }
 
    $myPage = str_replace("%tablerow%",$toAdd,$myPage);     
echo $myPage;
	}
?>
