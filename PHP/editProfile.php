<?php
    ob_start();
    session_start();
    $myPage = file_get_contents('editProfileContent.php');
    include_once("database.php");
    include_once("Model/user.php");

    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }

    // select loggedin users detail
    $myUser = $ODB->getUserFromID($_SESSION['user']);
    $myGroups = $ODB->getGroupsFromUserID($_SESSION['user']);
    $search = array('%Vorname%', '%Nachname%', '%UserName%', '%EMail%');
    $replace = array($myUser->getsFirstName(), $myUser->getsLastName(), $myUser->getsUsername(), $myUser->getsEMail());
    $myPage = str_replace($search,$replace,$myPage);


	
	if ( isset($_POST['btn-save']) ) {
        $error = false;
		/*PREVENT SQL INJECTION*/
		$username = trim($_POST['username']);
		$username = strip_Tags($username);
		$username = htmlspecialchars($username);
		
		$vorname = trim($_POST['vorname']);
		$vorname = strip_Tags($vorname);
		$vorname = htmlspecialchars($vorname);
		
		$nachname = trim($_POST['nachname']);
		$nachname = strip_Tags($nachname);
		$nachname = htmlspecialchars($nachname);
		
		$email = trim($_POST['email']);
		$email = strip_Tags($email);
		$email = htmlspecialchars($email);
		
		$passwort = trim($_POST['passwort']);
		$passwort = strip_Tags($passwort);
		$passwort = htmlspecialchars($passwort);
		
		
		if ((!empty($username))&&(strlen($username)<3)) {
			$error = true;
			$usernameError = "Ihr Benutzername muss länger als 3 Zeichen sein";
		}
		
		if(!preg_match("/^[a-zA-Z ]+$/",$vorname)) {
			$error = true;
			$vornameError = "Ihr Vorname darf keine Sonderzeichen enthalten";
		}
		
		
		if(!preg_match("/^[a-zA-Z ]+$/",$nachname)) {
			$error = true;
			$nachnameError = "Ihr Nachname darf keine Sonderzeichen enthalten";
		}

		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Bitte geben Sie eine gültige E-Mail Adresse ein.";
		} else {
            if ($ODB->isEmailTaken($email) == true){
                $error = true;
                $emailError = "Ihre angegebene E-Mail ist bereits vergeben.";
            }
		}
	
        if ($ODB->isUsernameTaken($username)== true){
			$error = true;
			$usernameError = "Dieser Username ist bereits vergeben.";
		}

		
      }

    echo $myPage;
         
?>