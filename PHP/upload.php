<?php
    ob_start();
    session_start();
    include_once("database.php");
    include_once("Model/User.php");

    // if session is not set this will redirect to login page
    if( !isset($_SESSION['user']) ) {
        header("Location: ../index.php");
        exit;
    }

    $myUser = $ODB->getUserFromID($_SESSION['user']);
    $upload_folder = "../ProfilePics/";
    $filename = pathinfo($_FILES['datei']['name'], PATHINFO_FILENAME); //Gibt Dateinamen zurück
    $extension = strtolower(pathinfo($_FILES['datei']['name'], PATHINFO_EXTENSION));    //Gibt Endung der Datei zurück zB php

    //Überprüfung der Dateiendung
    $allowed_extensions = array('png', 'jpg', 'jpeg');
    if(!in_array($extension, $allowed_extensions)) {
        die("Ungültige Dateiendung. Nur png, jpg und jpeg-Dateien sind erlaubt");
    }

    if(function_exists('exif_imagetype')) { //Die exif_imagetype-Funktion erfordert die exif-Erweiterung auf dem Server
        $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
        $detected_type = exif_imagetype($_FILES['datei']['tmp_name']);
        if(!in_array($detected_type, $allowed_types)) {
            die("Nur der Upload von Bilddateien und höchstens 2MB großen Bilddateien ist gestattet");
        }
     }

    //Pfad zum Upload
    $new_path = $upload_folder.$filename.'.'.$extension;

    //Neuer Dateiname falls die Datei bereits existiert
    if(file_exists($new_path)) { //Falls Datei existiert, hänge eine Zahl an den Dateinamen
        $id = 1;
        do {
            $new_path = $upload_folder.$filename.'_'.$id.'.'.$extension;
            $id++;
        } while(file_exists($new_path));
    }

    //Alles okay, verschiebe Datei an neuen Pfad
    
    //move_uploaded_file($_FILES['datei']['tmp_name'], $new_path);
    rename($_FILES['datei']['tmp_name'],$new_path);
    chmod($new_path, 0644);
    echo 'Bild erfolgreich hochgeladen';
    
    $ODB->setProfilePic($new_path,$myUser->getID());

    header("Location: editProfile.php");

?>