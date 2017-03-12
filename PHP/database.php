<?php
    foreach (glob("model/*.php") as $filename)
    {
        include_once( $filename);
    }
    class Database
    {
        private $db_connection;

        private function query($statement) {
            return mysqli_query($this->db_connection, $statement);
        }

        public function __construct(){
            $this->db_connection = mysqli_connect('localhost', 'root', '', 'iiigel');   
        }
        
        public function getUserFromId($ID){
            $res = $this->query("SELECT * FROM Users WHERE Users.ID ='$ID'");
            if (mysqli_num_rows($res)==1){
                $row = mysqli_fetch_array($res);
                    return new User($row['ID'],$row['sID'],$row['sUsername'],$row['sFirstName'],
                                    $row['sLastName'],$row['sEMail'],$row['sHashedPassword'],
                                    $row['sProfilePicture'],$row['bIsVerified'],$row['bIsAdmin'],$row['bIsOnline']);
            } else {
                throw new exception('Mehr als ein User mit dieser ID');        
            }
        }
        public function getInstitutionFromId($ID){
            $res = $this->query("SELECT * FROM Institutions WHERE Institutions.ID ='$ID'");
            if (mysqli_num_rows($res)==1){
                $row = mysqli_fetch_array($res);
                    return new Institution($row['ID'],$row['sID'],$row['sName'],$row['bIsDeleted']);
            } else {
                throw new exception('Mehr als eine Institution mit dieser ID');        
            }
        }
        
        public function getUserFromUsername($Username){
            $res = $this->query("SELECT * FROM Users WHERE Users.sUserName ='$Username'");
            if (mysqli_num_rows($res)==1){
                $row = mysqli_fetch_array($res);
                    return new User($row['ID'],$row['sID'],$row['sUsername'],$row['sFirstName'],
                                    $row['sLastName'],$row['sEMail'],$row['sHashedPassword'],
                                    $row['sProfilePicture'],$row['bIsVerified'],$row['bIsAdmin'],$row['bIsOnline']);
            } else {
                throw new exception('Mehr als ein User mit diesem Benutzernamen');        
            }
        }
        public function getGroupFromID($ID){
         $res = $this->query("SELECT * FROM Groups WHERE Groups.ID ='$ID'");
            $iNumResults = mysqli_num_rows($res);
            if ($iNumResults == 1) {
                $oTeilnehmerOfGroupResult = $this->query(
                    "SELECT users.ID,users.sID,users.sUsername,users.sFirstName,users.sLastName,users.sEMail," .
                    "users.sHashedPassword,users.sProfilePicture,users.bIsVerified,users.bIsAdmin," .
                    "users.bIsOnline,usertogroup.iFortschritt,usertogroup.bIsTrainer " .
                    "FROM users INNER JOIN usertogroup ON users.ID = usertogroup.UserID " .
                    "WHERE usertogroup.GroupID = " . $ID . " ORDER BY users.sFirstName ASC");
                $aTeilnehmerOfGroup = [];
                while (($oTeilnehmer = mysqli_fetch_row($oTeilnehmerOfGroupResult)) != NULL) {
                    //ToDo: switch to non-indice based access of db-column
                    $aTeilnehmerOfGroup[] = new Teilnehmer($oTeilnehmer[0], $oTeilnehmer[1], $oTeilnehmer[2],
                        $oTeilnehmer[3], $oTeilnehmer[4], $oTeilnehmer[5], $oTeilnehmer[6], $oTeilnehmer[7],
                        $oTeilnehmer[8], $oTeilnehmer[9], $oTeilnehmer[10], $oTeilnehmer[11], $oTeilnehmer[12]);
                }
                $row = mysqli_fetch_array($res);
                return new Group($row['ID'], $row['ModulID'], $row['InstitutionsID'], $row['sName'], $row['bIsDeleted'],
                    $aTeilnehmerOfGroup);
            } else if ($iNumResults == 0) {
                throw new exception('Keine Gruppe mit dieser ID in der Datenbank');
            } else {
                throw new exception('Mehr als eine Gruppe mit dieser ID');        
            }
        }
        
        
        public function getGroupsFromUserID($ID){
            $oGroupResult = $this->query("SELECT `GroupID` FROM `usertogroup` WHERE `UserID`='$ID'");
            $aGroups = [];
            while (($row = mysqli_fetch_row($oGroupResult)) != NULL) {
                $aGroups[] = $this->getGroupFromID($row[0]); 
            }
            return $aGroups;
                
        }
        
        public function getModuleFromID($ID){
            $res = $this->query("SELECT * FROM Modules WHERE Modules.ID ='$ID'");
            $iNumResults = mysqli_num_rows($res);

            if ($iNumResults == 1) {
                $oModuleRow = mysqli_fetch_array($res);
                $oChaptersResult = $this->query("SELECT * FROM chapters WHERE ModulID = " . $ID . " ORDER BY iIndex");
                $aChapters = [];
                while (($row = mysqli_fetch_row($oChaptersResult)) != NULL) {
                    //ToDo: switch to non-indice based access of db-column
                    $aChapters[] = new Chapter($row[0], $row[1], $row[2], $row[3],
                        $row[4], $row[5], $row[6], $row[7], $row[8],
                        $row[9], $row[10], $row[11], $row[12]);
                }
                return new Module($oModuleRow['ID'], $oModuleRow['sID'], $oModuleRow['sName'],
                    $oModuleRow['sDescription'], $oModuleRow['sLanguage'], $oModuleRow['sIcon'],
                    $oModuleRow['bIsDeleted'], $oModuleRow['bIsLive'], $aChapters);
            } else if ($iNumResults == 0) {
                throw new exception('Kein Modul mit dieser ID in der Datenbank');
            } else {
                throw new exception('Mehr als ein Modul mit dieser ID');        
            }
        }
    }


    global $ODB;
    $ODB = new Database();  
?>