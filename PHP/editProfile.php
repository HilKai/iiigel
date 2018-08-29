<?php
    ob_start();
    session_start();
    include_once("database.php");
    include_once("Model/user.php");
	include_once("Navigation.php");

    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: ../index.php");
        exit;
    }
	
	
	global $myUser;
    $myUser = $ODB->getUserFromID($_GET['userID']);
    $userID= $myUser->getID();
	
	$myPage = file_get_contents('../JQuery/querrychangePasswort.js');
	$myPage = str_replace("%userID%",$userID,$myPage);

	$sessionID = $_SESSION['user'];
	echo str_replace("%sessionID%",$sessionID, $myPage);
	 
	if(!$ODB->hasPermission($_SESSION['user'],"ProfilEditor","edit",$userID) and $_SESSION['user']!=$userID ) {
		$myPage = file_get_contents('../HTML/Error.html');
		echo $myPage;
        exit;
    } else {

	$myPage = str_replace('%Navigation%',getNavigation(),$myPage);
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
             if ($ODB->isViableUsername($userID, $username) == false){
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
                if ($ODB->isViableEMail($userID, $email) == false){
                    $error = true;
                    $emailError = "Ihre angegebene E-Mail ist bereits vergeben.";
                }
            }
        }
        
        if( !$error ) {
           if (!empty($username)) {$ODB->setUsernameFromID($username,$userID);};
           if (!empty($vorname)) {$ODB->setFirstNameFromID($vorname,$userID);};
           if (!empty($nachname)) {$ODB->setLastNameFromID($nachname,$userID);};
           if (!empty($email)) {$ODB->setEMailFromID($email,$userID);};
            unset($username);
            unset($vorname);
            unset($nachname);
            unset($email);
		    header("Location: editProfile.php?userID=".$userID);
	   } 

		
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<!-- Schrift -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	</head>

	<body onload="loadAction()">

		<div id="WrappingContainer" class="container">

			<div id="ProfileContainer" class="row">

				<div id="PicContainer" class="col-md-3 col-xs-2 hidden-xs noPadding">

					<div id="ProfilePic" class="img-responsive img-circle" style="background-image: url(<?php echo $ODB->getProfilePicFromID($myUser->getID()); ?>); background-size: cover;"> </div>

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
								<label for="exampleInputFile" class="label noPadding"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Profilbild hochladen</label>
								<form action="upload.php" method="post" enctype="multipart/form-data">
									<!--<input type="hidden" name="MAX_FILE_SIZE" value="800000" />-->
									<input type="file" name="datei" value="Hochladen" id="exampleInputFile" style="float:left;">
									<button id="Hochladen" type="submit" class="btn btn-default" name="Hochladen">Hochladen</button>
								</form>
							</div>
						</div>

						<div class="col-md-2 noPadding">
							<button id="PasswortButton" class="btn btn-default" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span> Passwort ändern</button>
						</div>
					</div>

					<!-- Modal -->
					<div id="myModal" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" onclick="deleteDanger()">&times;</button>
									<h4 class="modal-title">Passwort ändern</h4>
								</div>
								<form id="myForm2" action="" method="post" autocomplete="off">
									<div class="modal-body">
										<div class="form-group">
											<label for="exampleInputPrename">neues Passwort</label>
											<input id="pw1" type="text" name="passwort1" class="form-control form" value="">
											<span id="passError" class="text-danger"></span>
										</div>

										<div class="form-group">
											<label for="exampleInputPrename">Passwort wiederholen</label>
											<input id="pw2" type="text" name="passwort2" class="form-control form" value="">
										</div>
									</div>
									<!---type="submit" value="text" name="newPass" -->
								</form>
								<div class="modal-footer">
									<button id="ModalBtn" class="btn btn-default" onclick="setNewPass(); deleteDanger() ">Passwort ämdern</button>
								</div>
							</div>

						</div>
					</div>


					<form id="myForm" method="post" action="" autocomplete="off">
						<div class="row">
							<div class="col-md-6 noPadding">
								<div class="form-group">
									<label for="exampleInputPrename">Vorname</label>
									<input type="text" name="vorname" class="form-control form" value="<?php if(isset($vorname))  echo $vorname; ?>" placeholder="<?php echo $myUser->getsFirstName(); ?>">
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

								<button id="PinkButton" type="submit" class="btn btn-block btn-primary pinkButton" name="btn-save">Speichern</button>
							</div>
						</div>
					</form>

					<div class="col-md-2">
						<form id="ZurückButton" action="../PHP/userOverview.php">
							<button id="Button" type="submit" class="btn btn-default">Zurück</button>
						</form>
					</div>

				</div>



			</div>

		</div>

	</body>

	</html>
