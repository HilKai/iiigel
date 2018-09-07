<?php

    include_once("database.php");
	function getNavigation($showHome=true){
		$navigation = file_get_contents('../HTML/Navigation.html');
		
		// if session is not set this will redirect to login page
		if( !isset($_SESSION['user']) ) {
			header("Location: ../index.php");
			return '';
		}
		
		// Editor
		$userIsEditor = false;
        $userIsLeader = false;
		
		$editor = file_get_contents('../HTML/NavigationEditor.html');
        $leader = file_get_contents('../HTML/NavigationInstitutionLeader.html');
		$toAdd = "";
        $toAddIns = "";
        
        
        if ($GLOBALS["ODB"]->isAdmin($_SESSION['user'])){
            $modules = $GLOBALS["ODB"]->getAllModules();
            for ($i=0;$i<count($modules);$i++){
                $myRow = "<li><a class='dropdown-item' href='EditorModulView.php?modulID=%ID%'>%Name%</a></li>" ;
                $userIsEditor = true;
                $search = array("%Name%","%ID%");
                $replace = array($modules[$i]->getsName(),$modules[$i]->getID());
                $myRow = str_replace($search,$replace,$myRow);
                $toAdd = $toAdd . $myRow;
            }
            
        } else {
		  $permission = $GLOBALS["ODB"]->getPermissionsFromName("Modul");
			while(($permissionRow = mysqli_fetch_array($permission))!=null){
				
				$currentUser = $GLOBALS["ODB"]->getUserFromID($permissionRow["UserID"]);
				if ($_SESSION['user'] === $currentUser->getID()){
					$myRow = "<li><a class='dropdown-item' href='EditorModulView.php?modulID=%ID%'>%Name%</a></li>" ;
					$userIsEditor = true;
					$search = array("%Name%","%ID%");
        			$replace = array($GLOBALS["ODB"]->getModuleFromID($permissionRow["pID"])->getsName(),$permissionRow["pID"]);
					$myRow = str_replace($search,$replace,$myRow);
					$toAdd = $toAdd . $myRow;
				}
            }      	
		}
        
        if ($GLOBALS["ODB"]->isInstitutionsLeader($_SESSION['user'])and(!$GLOBALS["ODB"]->isAdmin($_SESSION['user']))){
            $institution = $GLOBALS["ODB"]->getAllInstitutionsFromLeader($_SESSION['user']);
                while(($institutionRow = mysqli_fetch_array($institution))!=null){

                    $currentUser = $GLOBALS["ODB"]->getUserFromID($institutionRow["UserID"]);
                    if ($_SESSION['user'] === $currentUser->getID()){
                        $myRowIns = "<li><a class='dropdown-item' href='AdminInstitutionDetailView.php?InstitutionsID=%ID%'>%Name%</a></li>" ;
                        $userIsLeader = true;
                        $search = array("%Name%","%ID%");
                        $replace = array($GLOBALS["ODB"]->getInstitutionFromID($institutionRow["ID"])->getsName(),$institutionRow["ID"]);
                        $myRowIns = str_replace($search,$replace,$myRowIns);
                        $toAddIns = $toAddIns . $myRowIns;
                    }
                }
       }
        
        
		$editor = str_replace("%ModulListe%",$toAdd,$editor);
		if (($userIsEditor === true)or($GLOBALS["ODB"]->isAdmin($_SESSION['user']))){
			$navigation = str_replace("%Editor%",$editor,$navigation);
		} else {
				$navigation = str_replace("%Editor%","",$navigation);
		}
        
		if($GLOBALS["ODB"]->isAdmin($_SESSION['user'])) {		//Admin Dropdown 
			$dropdown= file_get_contents('../HTML/NavigationAdminDropdown.html');
		} else {
			$dropdown = '';
		}
		$navigation = str_replace("%AdminDropdown%",$dropdown,$navigation);
        
        $leader = str_replace("%InstitutionsListe%",$toAddIns,$leader);
		if ($GLOBALS["ODB"]->isInstitutionsLeader($_SESSION['user'])and(!$GLOBALS["ODB"]->isAdmin($_SESSION['user']))){
			$navigation = str_replace("%Leader%",$leader,$navigation);
		} else {
            $navigation = str_replace("%Leader%","",$navigation);
		}
		
		// Sign Out
		$signOut = file_get_contents('../HTML/NavigationSignOut.html');
		$navigation = str_replace("%SignOut%",$signOut,$navigation);
			
		//Home Button
		if ($showHome === true){
			$home = file_get_contents('../HTML/NavigationHome.html');
			
		} else {
			$home = '';
		}
		
		$navigation = str_replace("%Home%",$home,$navigation);
	
		return  $navigation;
	}
?>