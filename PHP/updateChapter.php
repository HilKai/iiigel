<?php
    inlcude_once("database.php");
    $ODB->setChapterTextFromID($_GET['text'],$_GET['chapterID']);
    
?>