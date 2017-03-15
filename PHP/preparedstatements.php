<?php

    global $ODB;
    $ODB = new Database(); 

    $stmtGetUserFromID = $ODB->prepare("SELECT * FROM Users WHERE Users.ID = ?");
    if ($stmtGetUserFromID->execute(array($_GET['ID']))) {
      while ($row = $stmtGetUserFromID->fetch()) {
        print_r($row);
      }
    }

    $stmtGetInstitutionFromID = $ODB->prepare("SELECT * FROM Institutions WHERE Institutions.ID = ?");
    if ($stmtGetInstitutionFromID->execute(array($_GET['ID']))) {
      while ($row = $stmtGetInstitutionFromID->fetch()) {
        print_r($row);
      }
    }

    $stmtGetUserFromUsername = $ODB->prepare("SELECT * FROM Users WHERE Users.sUserName = ?");
    if ($stmtGetUserFromUsername->execute(array($_GET['UserName']))) {
      while ($row = $stmtGetUserFromUsername->fetch()) {
        print_r($row);
      }
    }
    
    $stmtGetGroupFromID = $ODB->prepare("SELECT * FROM Groups WHERE Groups.ID = ?");
    if ($stmtGetGroupFromId->execute(array($_GET['ID']))) {
      while ($row = $stmtGetGroupFromId->fetch()) {
        print_r($row);
      }
    }

    $stmtGetGroupsFromUserID = $ODB->prepare("SELECT `GroupID` FROM `usertogroup` WHERE `UserID`= ?");
    if ($stmtGetGroupsFromUserID->execute(array($_GET['UserID']))) {
      while ($row = $stmtGetGroupsFromUserID->fetch()) {
        print_r($row);
      }
    }

    $stmtGetModuleFromID = $ODB->prepare("SELECT * FROM Modules WHERE Modules.ID = ?");
    if ($stmtGetModuleFromID->execute(array($_GET['ID']))) {
      while ($row = $stmtGetModuleFromID->fetch()) {
        print_r($row);
      }
    }
?>