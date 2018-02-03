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
		
		$editor = file_get_contents('../HTML/NavigationEditor.html');
		$toAdd = "";
		$permission = $GLOBALS["ODB"]->getPermissionsFromName("Modul");
			while(($permissionRow = mysqli_fetch_array($permission))!=null){
				
				$currentUser = $GLOBALS["ODB"]->getUserFromID($permissionRow["UserID"]);
				if ($_SESSION['user'] === $currentUser->getID()){
					$myRow = "<li><a class='dropdown-item' href='EditorModulView.php?modulID=%ID%'>%Name%</a></li>" ;
					$userIsEditor = true;
					$search = array("%Name%","%ID%");
        			$replace = array($GLOBALS["ODB"]->getModuleFromID($permissionRow["ID"])->getsName(),$permissionRow["ID"]);
					$myRow = str_replace($search,$replace,$myRow);
					$toAdd = $toAdd . $myRow;
				}
        	
        
        	
		}
		$editor = str_replace("%ModulListe%",$toAdd,$editor);
		if ($userIsEditor === true){
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