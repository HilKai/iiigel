<?php
    include_once("database.php");
    echo $ODB->replaceTags($_GET['text']);
?>
