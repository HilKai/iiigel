<?php
	

	function getNavigation($showHome=true){
		$navigation = file_get_contents('../HTML/Navigation.html');
		
		// if session is not set this will redirect to login page
		if( !isset($_SESSION['user']) ) {
			header("Location: ../index.php");
			return '';
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