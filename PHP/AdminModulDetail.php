 <?php 
    include_once("database.php");
    $myPage = file_get_contents('../HTML/AdminModulDetailView.html');
  
    
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
    
?>
