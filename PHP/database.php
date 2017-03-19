<?php
    foreach (glob("model/*.php") as $filename)
    {
        include_once( $filename);
    }
    class Database
    {
        private $db_connection;
		private $stmtGetUserFromID;
		private $stmtGetInstitutionFromID;
		private $stmtGetUserFromUsername;
		private $stmtGetGroupFromID;
		private $stmtGetGroupsFromUserID;
		private $stmtGetModuleFromID;

        private function query($statement) {
            return mysqli_query($this->db_connection, $statement);
        }

        public function __construct(){
            $this->db_connection = mysqli_connect('localhost', 'root', '', 'iiigel');
			$this->stmtisEmailTaken = $this->db_connection->prepare("SELECT sEMail FROM users WHERE users.sEMail = ?");
			$this->stmtisUsernameTaken = $this->db_connection->prepare("SELECT sUsername FROM users WHERE users.sUsername = ?");
			$this->stmtGetUserFromID = $this->db_connection->prepare("SELECT * FROM users WHERE users.ID = ?");
			$this->stmtGetInstitutionFromID = $this->db_connection->prepare("SELECT * FROM Institutions WHERE Institutions.ID = ?");
			$this->stmtGetUserFromUsername = $this->db_connection->prepare("SELECT * FROM Users WHERE Users.sUserName = ?");
			$this->stmtGetGroupFromID = $this->db_connection->prepare("SELECT * FROM Groups WHERE Groups.ID = ?");
			$this->stmtGetGroupsFromUserID = $this->db_connection->prepare("SELECT `GroupID` FROM `usertogroup` WHERE `UserID`= ?");
			$this->stmtGetModuleFromID = $this->db_connection->prepare("SELECT * FROM Modules WHERE Modules.ID = ?");
        }
		
        public function replaceTags ($_sContent){
            $sMyDocument = str_replace('<', '&lt;', str_replace('>', '&gt;', $_sContent));
            $sTags = $this->query('SELECT sTagFrom,sTagIn FROM tags');        
            for ($x = 0; $x <= mysqli_num_rows($sTags);$x++) {
                $aRow = mysqli_fetch_row($sTags);
                $sMyDocument =  str_replace ($aRow['sTagFrom'],$aRow['sTagIn'],$sMyDocument);
            } 
            return $sMyDocument;
           }
        
        public function isEmailTaken($sEmail){
			$this->stmtisEmailTaken->bind_param("s",$sEmail);	
			$this->stmtisEmailTaken->execute();
			$res = $this->stmtisEmailTaken->get_result();
			$iAmountOfThisEmail = mysqli_num_rows($result);
            if ($iAmountOfThisEmail != 0) {
                return true;
            } else {
                return false;
            }
        }
        
        public function isUsernameTaken($sUsername){
            $this->stmtisUsernameTaken->bind_param("s",$Username);	
			$this->stmtisUsernameTaken->execute();
			$res = $this->stmtisUsernameTaken->get_result();
            $iNumberOfUsersWithThisUsername = mysqli_num_rows($result);
			if ($iNumberOfUsersWithThisUsername != 0) {
                return true;
            } else {
                return false;  
            }
        }
        
        public function getUserFromId($ID){	
			$this->stmtGetUserFromID->bind_param("i",$ID);	
			$this->stmtGetUserFromID->execute();
			$res = $this->stmtGetUserFromID->get_result();
            if (mysqli_num_rows($res)==1){
                $row = mysqli_fetch_array($res);
                    return new User($row['ID'],$row['sID'],$row['sUsername'],$row['sFirstName'],
                                    $row['sLastName'],$row['sEMail'],$row['sHashedPassword'],
                                    $row['sProfilePicture'],$row['bIsVerified'],$row['bIsAdmin'],$row['bIsOnline']);
            } else {
                throw new exception('Mehr als ein User mit dieser ID');        
            }	
            
        }
        public function getInstitutionFromID($ID){
			$this->stmtGetInstitutionFromID->bind_param("i",$ID);	
			$this->stmtGetInstitutionFromID->execute();
            $res = $this->stmtGetInstitutionFromID->get_result();
            if (mysqli_num_rows($res)==1){
                $row = mysqli_fetch_array($res);
                    return new Institution($row['ID'],$row['sID'],$row['sName'],$row['bIsDeleted']);
            } else {
                throw new exception('Mehr als eine Institution mit dieser ID');        
            }
        }
        
        public function getUserFromUsername($Username){
            $this->stmtGetUserFromUsername->bind_param("s",$Username);	
			$this->stmtGetUserFromUsername->execute();
            $res = $this->stmtGetUserFromUsername->get_result();
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
			$this->stmtGetGroupFromID->bind_param("i",$ID);	
			$this->stmtGetGroupFromID->execute();
            $res = $this->stmtGetGroupFromID->get_result();
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
            $this->stmtGetGroupsFromUserID->bind_param("i",$ID);	
			$this->stmtGetGroupsFromUserID->execute();
            $res = $this->stmtGetGroupsFromUserID->get_result();
            $aGroups = [];
            while (($row = mysqli_fetch_row($res)) != NULL) {
                $aGroups[] = $this->getGroupFromID($row[0]); 
            }
            return $aGroups;
                
        }
        
        public function getModuleFromID($ID){
            $this->stmtGetModuleFromID->bind_param("i",$ID);	
			$this->stmtGetModuleFromID->execute();
            $res = $this->stmtGetModuleFromID->get_result();
            $iNumResults = mysqli_num_rows($res);

            if ($iNumResults == 1) {
                $oModuleRow = mysqli_fetch_array($res);
                $oChaptersResult = $this->query("SELECT * FROM chapters WHERE ModulID = " . $ID . " ORDER BY iIndex");
                $aChapters = [];
                while (($row = mysqli_fetch_row($res)) != NULL) {
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