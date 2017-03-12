<?php
    ob_start();
    session_start();
    $myPage = file_get_contents('../HTML/userOverview.html');
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
    for ($i=0; $i< sizeof($myGroups);$i++){ 
	   
    }
    echo $myPage;
         
?>