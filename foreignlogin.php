<?php
    ob_start();
	session_start();
	include_once("PHP/database.php");
    if (isset($_SESSION['user'])!="" ) {
	  header("Location: PHP/userOverview.php");
	  exit;
	}
    $loginres = $ODB->getUserDataFromCodingSpace($_GET['authToken']);
    if ($loginres === false){
        header("Location: index.php");
    } else {
        $_SESSION['user'] = $loginres;
        header("Location: PHP/userOverview.php");
    }
?>