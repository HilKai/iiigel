<?php
    ob_start();
    session_start();
    include_once("database.php");
    include_once("Model/user.php");

    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $myUser = $ODB->getUserFromID($_SESSION['user']);

	
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

		
		if (!empty($username)) {
            if (strlen($username)<3) {
                $error = true;
                $usernameError = "Ihr Benutzername muss länger als 3 Zeichen sein";
            }
             if ($ODB->isViableUsername($_SESSION['user'], $username) == false){
			     $error = true;
			     $usernameError = "Dieser Username ist bereits vergeben.";
		    }
        }
		
        if (!empty($vorname)) {
            if(!preg_match("/^[a-zA-Z ]+$/",$vorname)) {
                $error = true;
                $vornameError = "Ihr Vorname darf keine Sonderzeichen enthalten";
            }
        }
		
		if (!empty($nachname)) {
            if(!preg_match("/^[a-zA-Z ]+$/",$nachname)) {
                $error = true;
                $nachnameError = "Ihr Nachname darf keine Sonderzeichen enthalten";
            }
        }
            
        if (!empty($email)) {
            if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
                $error = true;
                $emailError = "Bitte geben Sie eine gültige E-Mail Adresse ein.";
            } else {
                if ($ODB->isViableEMail($_SESSION['user'], $email) == false){
                    $error = true;
                    $emailError = "Ihre angegebene E-Mail ist bereits vergeben.";
                }
            }
        }
        
        if( !$error ) {
           if (!empty($username)) {$ODB->setUsernameFromID($username,$_SESSION['user']);};
           if (!empty($vorname)) {$ODB->setFirstNameFromID($vorname,$_SESSION['user']);};
           if (!empty($nachname)) {$ODB->setLastNameFromID($nachname,$_SESSION['user']);};
           if (!empty($email)) {$ODB->setEMailFromID($email,$_SESSION['user']);};
            unset($username);
            unset($vorname);
            unset($nachname);
            unset($email);
		    header("Location: editProfile.php");
	   } 

		
      }
 
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../bootstrap-3.3.7-dist\bootstrap-3.3.7-dist\css\bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="../Styles\editProfile.css" type="text/css">
        <!-- Schrift -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>

    <body>

        <div id="WrappingContainer" class="container">

            <div id="ProfileContainer" class="row">

                <div class="col-md-3 noPadding">

                    <img id="ProfilePic" class="img-responsive img-circle" src="<?php echo $ODB->getProfilePicFromID($myUser->getID()); ?>" alt="ProfilePic">

                </div>

                <div id="ProfileTextContainer" class="col-md-8">

                    <div id="" class="row">
                        <div class="col-md-12 noPadding">
                            <h1 id="Heading"> Profil bearbeiten</h1>
                        </div>
                    </div>

                    <div id="" class="row">
                        <div class="col-md-6 noPadding">
                                <div class="form-group">
                                    <form action = "upload.php" method="post" enctype="multipart/form-data">
                                        <label for="exampleInputFile"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Profilbild hochladen</label>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="800000" />
                                        <input type="file" name="datei" value="Hochladen" id="exampleInputFile">
                                        <button id = "PinkButton" type="submit" class="btn btn-block btn-primary" style="width: 100px;height:35px" name="Hochladen">Hochladen</button>
                                    </form>  
                                </div>
                        </div>

                        <div class="col-md-2 noPadding">
                            <button id="PasswortButton" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Passwort ändern</button>
                        </div>
                    </div>



                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                        <div class="row">
                            <div class="col-md-6 noPadding">
                                <div class="form-group">
                                    <label for="exampleInputPrename">Vorname</label>
                                    <input type="text" name="vorname" class="form-control form" value="<?php if(isset($vorname))  echo $vorname; ?>"  placeholder="<?php echo $myUser->getsFirstName(); ?>" >
                                    <span class="text-danger"><?php if(isset($vornameError)) echo $vornameError; ?> </span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputLastname">Nachname</label>
                                    <input type="text" name="nachname" class="form-control form" placeholder="<?php echo $myUser->getsLastName(); ?>" value="<?php if(isset($nachname)) echo $nachname; ?>">
                                    <span class="text-danger"><?php if(isset($nachnameError)) echo $nachnameError; ?> </span>
                                </div>

                            </div>
                            <div class="col-md-6 noPadding">

                                <div class="form-group">
                                    <label for="exampleInputUsername">Benutzername</label>
                                    <input type="text" name="username" class="form-control form" placeholder="<?php echo $myUser->getsUsername(); ?>" value="<?php if(isset($username))echo $username;?>">
                                    <span class="text-danger"><?php if(isset($usernameError)) echo $usernameError; ?> </span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputMail"><span class="glyphicon glyphicon-envelope"></span> E-Mail Adresse</label>
                                    <input type="email" name="email" class="form-control form" placeholder="<?php echo $myUser->getsEmail(); ?>" value="<?php if(isset($email)) echo $email;  ?>">
                                    <span class="text-danger"><?php if(isset($emailError)) echo $emailError; ?> </span>
                                </div>

                            </div>
                        </div>
                         <div id="" class="row">
                            <div class="col-md-2 noPadding">
                                <form method="post">
                                    <button id="PinkButton" type="submit" class="btn btn-block btn-primary" name="btn-save">Speichern</button>
                                </form>
                            </div>
                        </div>    
                     </form>
                            <form action="index.php">
                                <div class="col-md-2">
                                    <button id="Button" type="submit" class="btn btn-default">Zurück</button>
                                </div>
                            </form>
                        </div>




                </div>

            </div>

    </body>

    </html>
