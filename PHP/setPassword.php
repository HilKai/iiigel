<?php
	include_once("database.php");
	$myUser = $ODB->getUserFromID($_POST['userID']);
	$error = false; 
	$passError ="";
		$passwort = trim($_POST['passwort1']);
		$passwort = strip_Tags($passwort);
		$passwort = htmlspecialchars($passwort);
		
		$passwortRepeat = trim($_POST['passwort2']);
		$passwortRepeat = strip_Tags($passwortRepeat);
		$passwortRepeat = htmlspecialchars($passwortRepeat);
		
		if (empty($passwort)) {
			$error = true;
			$passError = "Bitte geben Sie ein Passwort ein.";
		}else {
			if (strlen($passwort)<6){
				$error = true;
				$passError = "Das eingegebene Passwort ist zu kurz. Es muss länger als 6 Zeichen sein.";
			}
		}
		
		if ((!empty($passwort))&&(empty($passwortRepeat))) {
			$error = true;
			$passError = "Bitte wiederholen sie ihr Passwort";
		}else {
			if ($passwortRepeat != $passwort){
				$error = true;
				$passError = "Die beiden Passwörter stimmen nicht überein.";
			}
		}
		
		//if (empty($passwort)) && (empty($passwortRepeat)) $passError = "noPass";
		
		 $options = [
            'cost' => 11,
            'salt' => random_bytes (22)
        ];
		
        $hash_passwort = password_hash( $passwort, PASSWORD_BCRYPT, $options);
		if( !$error ) { 
            echo "success";
			$ODB->setPasswordFromID($hash_passwort,$myUser->getID());
		} else {
           	echo $passError; 
        }

     
		 
	 
?>