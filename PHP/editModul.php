<?php
    ob_start();
    session_start();
    include_once("database.php");
    include_once("Model/Module.php");
	include_once("Model/Chapter.php");
	include_once("Navigation.php");

    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: ../index.php");
        exit;
    }
    //TV Wenn der User nicht die Berechtigung hat
	if(!$ODB->hasPermission($_SESSION['user'],"Modul","edit",$myChapterID) ) {
        echo "Sie haben nicht die benötigte Berechtigung um diese Seite anzusehen.";
        exit;
    } else {

	global $myModule;
    $myModule = $ODB->getModuleFromID($_GET['moduleID']);
    $moduleID= $myModule->getID();
		
	
	$myPage = str_replace('%Navigation%',getNavigation(),$myPage);

	 if ( isset($_POST['btn-save']) ) {
        $error = false;
		/*TV PREVENT SQL INJECTION*/
		$modulename = trim($_POST['modulename']);
		$modulename = strip_Tags($modulename);
		$modulename = htmlspecialchars($modulename);
		
		$description = trim($_POST['description']);
		$description = strip_Tags($description);
		$description = htmlspecialchars($description);
  
        if( !$error ) {
           if (!empty($modulename)) {$ODB->setModuleNameFromID($modulename,$moduleID);};
           if (!empty($description)) {$ODB->setModuleDescriptionFromID($description,$moduleID);};
            unset($modulename);
            unset($description);
		    header("Location: editModul.php?moduleID=".$moduleID);
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

	<body>

		<div id="WrappingContainer" class="container">

			<div id="ProfileContainer" class="row">

				<div id="ProfileTextContainer" class="col-md-6">
					<div id="" class="row">
						<div class="col-md-12 noPadding">
							<h1 id="Heading"> Modul bearbeiten</h1>
						</div>
					</div>

					<form id="myForm" method="post" action="" autocomplete="off">
						<div class="row">
							<div class="col-md-12 noPadding">
								<div class="form-group">
									<label for="exampleInputModulname">Modulname</label>
									<input type="text" name="modulename" class="form-control form" value="<?php if(isset($vorname))  echo $vorname; ?>" placeholder="<?php echo $myModule->getsName(); ?>">
									<span class="text-danger"><?php if(isset($vornameError)) echo $vornameError; ?> </span>
								</div>
								<div class="form-group">
									<label for="exampleInputDescription">Beschreibung</label>
									<textarea rows="4" type="text" name="description" class="form-control form" placeholder="<?php echo $myModule->getsDescription(); ?>" value="<?php if(isset($nachname)) echo $nachname; ?>"></textarea>
									<span class="text-danger"><?php if(isset($nachnameError)) echo $nachnameError; ?> </span>
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

				<div id="ChapterContainer" class="col-md-4">

					<h3 class="heading3">Kapitel<span class="glyphicon glyphicon-pencil"></span></h3>

					<table class="table black">
						<tbody>
							<?php 
									$toAdd = "";
									for ($i=0; $i< sizeof($myModule->chapter);$i++){  
    									$myRow = file_get_contents('../HTML/editModulListItem.html');
										$search = array('%ModuleID%','%ChapterID%','%ChapterTitle%');
										$replace = array($moduleID,$myModule->chapter[$i]->getID(), $myModule ->chapter[$i]->getsTitle());
										$myRow = str_replace($search,$replace,$myRow);
								    	$toAdd = $toAdd . $myRow;
    								}
									echo $toAdd;
								?>
						</tbody>
					</table>
				</div>



			</div>

		</div>

	</body>

	</html>
