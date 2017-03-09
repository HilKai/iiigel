<?php
    ob_start();
    session_start();
    $myPage = file_get_contents('../HTML/userOverview.html');
    include_once("database.php");


    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    // select loggedin users detail
    $myUser = $ODB->getUserFromID($_SESSION['user']);
    $search = array('%Vorname%', '%Nachname%');
    $replace = array($myUser->getsFirstName(), $myUser->getsLastName());
    $myPage = str_replace($search,$replace,$myPage);
    echo $myPage;
         
?>