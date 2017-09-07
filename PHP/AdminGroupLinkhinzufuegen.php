<?php
    include_once('database.php');
    $ODB->addGroupInvitationLink($_POST['link'],$_POST['GroupID'],date('Y-m-d H:i:s',strtotime($_POST['startdate'])),date('Y-m-d H:i:s',strtotime($_POST['enddate'])));
    header("Location:AdminGroupDetailView.php?GroupID=".$_POST['GroupID']);

?>
