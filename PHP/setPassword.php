<?php
	include_once("database.php");
	$myUser = $ODB->getUserFromID($_POST['userID']);
	$error = "false"; 
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
		
		if (empty($passwortRepeat)) {
			$error = true;
			$passRepeatError = "Bitte wiederholen sie ihr Passwort";
		}else {
			if ($passwortRepeat != $passwort){
				$error = true;
				$passError = "Die beiden Passwörter stimmen nicht überein.";
			}
		}
		
		 $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
		
        $hash_passwort = password_hash( $passwort, PASSWORD_BCRYPT, $options);
		
		if( !$error ) { 
			$ODB->setPasswordFromID($hash_passwort,$myUser->getID());
		}

     	echo $passError;
		 
	 
?>