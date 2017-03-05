<?php 

	ob_start();
	session_start();
	include_once 'DBConnection.php';
	$error = false;

	if (isset($_SESSION['user'])!="") {
		header("Location: home.php");
	}
	
	if ( isset($_POST['btn-signup']) ) {
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
		
		$passwort = trim($_POST['password']);
		$passwort = strip_Tags($password);
		$passwort = htmlspecialchars($password);
		
		if (empty($username)) {
			$error = true;
			$usernameError = "Geben Sie bitte einen Benutzernamen ein.";
		}
		
		if (strlen($username)<3) {
			$error = true;
			$usernameError = "Ihr Benutzername muss länger als 3 Zeichen sein";
		}
		
		if (empty($vorname)) {
			$error = true;
			$usernameError = "Geben Sie bitte einen Vornamen ein.";
		}
		
		if(!preg_match("/^[a-zA-Z ]+$/",$vorname)) {
			$error = true;
			$vornameError = "Ihr Vorname darf keine Sonderzeichen enthalten";
		}
		
		if (empty($nachname)) {
			$error = true;
			$nachnameError = "Geben Sie bitte einen Nachnamen ein.";
		}
		
		if(!preg_match("/^[a-zA-Z ]+$/",$nachname)) {
			$error = true;
			$nachnameError = "Ihr Nachname darf keine Sonderzeichen enthalten";
		}

		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		} else {
			$query = "SELECT sEMail FROM users WHERE users.sEMail = '$email'";
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
				if ($count != 0) {
					$error = true;
					$emailError = "Ihre angegebene E-Mail ist bereits vergeben.";
				}
		}
	
		$query = "SELECT sUsername FROM users WHERE users.sUsername = '$username'";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
			
		if ($count != 0) {
			$error = true;
			$userError = "Dieser Username ist bereits vergeben.";
		}
		
		if (empty($passwort)) {
			$error = true;
			$passError = "Bitte geben Sie ein Passwort ein.";
		}else {
			if (strlen($passwort)<6){
				$error = true;
				$passError = "Das eingegebene Passwort ist zu kurz. Es muss länger als 6 Zeichen sein.";
			}
		}
		
		$hash_passwort = hash('sha256', $passwort);
			

		if( !$error ) {
	   
		   $query = "INSERT INTO users (Username,Vorname,Name,EMail,Passwort) VALUES('$username','$vorname','$nachname','$email','$hash_passwort')";
		   $res = mysql_query($query);
			
		   if ($res) {
				$errTyp = "success";
				$errMSG = "Successfully registered, you may login now";
				unset($username);
				unset($vorname);
				unset($nachname);
				unset($email);
				unset($passwort);
		   } else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later..."; 
		   } 
			
		}
	}
?>

<html>

	<head>
		<link rel="stylesheet" href="../Styles/layout.css" type="text/css"> 
		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		
		<!-------------------------------BOOTSTRAP-------------------------------->
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" 
		integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		
	</head>
	
	<body class="body">
		<div id="WrappingContainer" class="container">
			
			<div id="register_Container" class="col-md-6 col-md-offset-3">
				<p>Registrieren</p>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
					<?php
						if (isset($errMSG)) {
							
					?>
						<div class="form-group">
							<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
								<span class="glyphicon glyphicon-info-sign"></span> 
								<?php echo $errMSG; ?>
							</div>
						</div>
							<?php
						   }
						   ?>
						
					<div class="form-group">
						<label for="exampleInputEmail1">Username</label>
						<input type="email" class="form-control" value="<?php echo $username ?>" id="exampleInputEmail1" placeholder="Username">
						 <span class="text-danger"><?php echo $usernameError; ?></span>
					</div>
					
					<div class="form-group">
						<label for="exampleInputEmail1">Vorname</label>
						<input type="email" class="form-control" value="<?php echo $vorname ?>" id="exampleInputEmail1" placeholder="Vorname">
						 <span class="text-danger"><?php echo $vornameError; ?></span>
					</div>
					
					<div class="form-group">
						<label for="exampleInputEmail1">Nachname</label>
						<input type="email" class="form-control" value="<?php echo $nachname ?>" id="exampleInputEmail1" placeholder="Nachname">
						 <span class="text-danger"><?php echo $nachnameError; ?></span>
					</div>
					
					<div class="form-group">
						<label for="exampleInputEmail1">Email address</label>
						<input type="email" class="form-control" value="<?php echo $email ?>" id="exampleInputEmail1" placeholder="Email">
						 <span class="text-danger"><?php echo $emailError; ?></span>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Password</label>
						<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
						 <span class="text-danger"><?php echo $passError; ?></span>
					</div>
					
					<button name="btn-signUp" type="submit" class="btn btn-default">Registrieren</button>
				</form>
			</div>
				
		</div>
	</body>

</html>
<?php ob_end_flush(); ?>