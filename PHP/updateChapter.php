<?php
    include_once("database.php");

    $ODB->setChapterTextFromID($_POST['text'],$_POST['chapterID']);
?>