<?php 
	ob_start();
	session_start();
	include_once("PHP/database.php");
	$error = false;
	if (isset($_SESSION['user'])!="" ) {
	  header("Location: PHP/userOverview.php");
	  exit;
	}
	
	if ( isset($_POST['btn-signin']) ) {
		/*PREVENT SQL INJECTION*/
		$username = trim($_POST['username']);
		$username = strip_Tags($username);
		$username = htmlspecialchars($username);
		
		$passwort = trim($_POST['passwort']);
		$passwort = strip_Tags($passwort);
		$passwort = htmlspecialchars($passwort);
		
		if (empty($username)) {
			$error = true;
			$usernameError = "Geben Sie bitte einen Benutzernamen an.";
		}
		
		
		
		if (empty($passwort)) {
			$error = true;
			$passError = "Bitte geben Sie ein Passwort an.";
		}
		
		
			

		if( !$error ) {
	   
		    $myUser = $ODB->getUserFromUsername($username);  
           
		if( ($myUser->verifyPassword($passwort)&&(!$ODB->isUserDeleted($myUser->getID())))){
			$_SESSION['user'] = $myUser->getID();
            
            if ($_POST["reg"]!=""){
                $ODB->processRegistrationLink($myUser->getID(),$_POST["reg"]);
            }
			header("Location: PHP/userOverview.php");
        }elseif($ODB->isUserDeleted($myUser->getID())){
            $errMSG = "Dieser Benutzer existiert nicht.";
		   } else {
			$errMSG = "Ihre Accountdaten sind falsch. Bitte geben Sie diese erneut ein";
		   }
			
		}
	}
?>

    <html>

    <head>
        <link rel="stylesheet" href="Styles/layout.css" type="text/css">
        <base href="/iiigel/">
        <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

        <!-------------------------------BOOTSTRAP-------------------------------->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    </head>

    <body class="body">
        <div id="WrappingContainer" class="container  ">
            
            <div id="login_Container" class="col-md-6 col-md-offset-3">

                <h3 style="margin-top:10px;">Login <span class="glyphicon glyphicon-log-in"></span></h3>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                    <?php
						if (isset($errMSG)) {
							
					?>
                        <div class="form-group">
                            <div class="alert alert-<?php echo ($errTyp==" success ") ? "success " : $errTyp; ?>">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                <?php echo $errMSG; ?>
                            </div>
                        </div>
                        <?php
						   }
						   ?>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Username</label>
                                <input type="text" name="username" class="form-control" value="<?php if(isset($username)) echo $username; ?>" id="exampleInputEmail1" placeholder="Username">
                                <span class="text-danger"><?php if(isset($userNameError)) echo $userNameError; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Passwort</label>
                                <input type="password" name="passwort" class="form-control" id="exampleInputPassword1" placeholder="Passwort">
                                <span class="text-danger"><?php if(isset($passError)) echo $passError; ?></span>
                            </div>

                            <a href="PHP/register.php<?php if (isset($_GET['reg'])) {echo '?reg='.$_GET['reg'];}?>"> Noch keinen Account? Hier registrieren! </a>
                            <div class="form-group">
                                <input name="reg" id="reg" type="hidden" value="<?php if (isset($_GET['reg'])) {echo $_GET['reg'];}?>"> 
                                <button type="submit" class="btn btn-block btn-primary" name="btn-signin">Einloggen</button>
                            </div>

                </form>
            </div>

        </div>
    </body>

    </html>
    <?php ob_end_flush(); ?>