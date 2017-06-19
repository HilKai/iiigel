<?php

        include_once("Model/User.php");
        include_once("Model/Teilnehmer.php");
        include_once("Model/Institution.php");
        include_once("Model/Group.php");
        include_once("Model/Chapter.php");
        include_once("Model/Module.php");
    class Database
    {
        private $db_connection;
        private $stmtisEmailTaken;
        private $stmtisUsernameTaken;
        private $stmtisUsernameFromID;
        private $stmtisEMailFromID;
        private $stmtisUserinGroup;
        private $stmtisTrainerofGroup;
		private $stmtisNewHandIn;
        
		private $stmtGetUserFromID;
		private $stmtGetInstitutionFromID;
		private $stmtGetUserFromUsername;
		private $stmtGetGroupFromID;
		private $stmtGetGroupsFromUserID;
		private $stmtGetModuleFromID;
        private $stmtGetProfilePicFromUserID;
        private $stmtGetIDFromUsername;
        private $stmtCountInstitutions;
        private $stmtCountUsers;
        private $stmtCountInstitutionsFromUser;
        private $stmtGetAllInstitutions;
		private $stmtGetAllUsers;
        private $stmtGetModuleImageFromID;
        private $stmtgetInstitutionsFromUserID;
        
        private $stmtSetProfilePic;
        private $stmtSetFortschrittFromUserinGroup;
        private $stmtSetFortschrittforallUsersinGroup;
        private $stmtSetUsernameFromID;
        private $stmtSetFirstNameFromID;
        private $stmtSetLastNameFromID;
        private $stmtSetEMailFromID;
        private $stmtSetPasswordFromID;
        private $stmtSetModuleNameFromID;
        private $stmtSetModuleDescriptionFromID;
        private $stmtSetChapterTextFromID;
        private $stmtSetModuleImageFromID;
        private $stmtAcceptHandIn;
        
        private $stmtaddUser;
        private $stmtaddInstitution;
        private $stmtaddHandIn;
        private $stmtaddChaptertoModule;
        
        private $stmtdeleteUser;
        private $stmtdeleteHandIn;
       

        private function query($statement) {
            return mysqli_query($this->db_connection, $statement);
        }

        public function __construct(){
            //$this->db_connection = mysqli_connect('db676294632.db.1and1.com', 'dbo676294632', 'Supi!748', 'db676294632');
            $this->db_connection = mysqli_connect('localhost', 'root', '', 'iiigel');
            
            //----- SELECTS -----
			$this->stmtisEmailTaken = $this->db_connection->prepare("SELECT sEMail FROM users WHERE UPPER(users.sEMail) = UPPER(?)");
			$this->stmtisUsernameTaken = $this->db_connection->prepare("SELECT sUsername FROM users WHERE users.sUsername = ?");
            $this->stmtisUsernameFromID = $this->db_connection->prepare("SELECT ID FROM users WHERE sUsername = ?");
            $this->stmtisEMailFromID = $this->db_connection->prepare("SELECT ID FROM users WHERE UPPER(users.sEMail) = UPPER(?)");
            $this->stmtisUserinGroup = $this->db_connection->prepare("SELECT * FROM usertogroup WHERE UserID = ? AND GroupID = ?");
            $this->stmtisTrainerofGroup = $this->db_connection->prepare("SELECT * FROM usertogroup WHERE UserID = ? AND GroupID = ? AND bIsTrainer = 1 ");
			$this->stmtisNewHandIn = $this->db_connection->prepare("SELECT * FROM handins WHERE UserID = ? AND GroupID = ? AND bIsAccepted = 0");
			$this->stmtGetUserFromID = $this->db_connection->prepare("SELECT * FROM users WHERE users.ID = ?");
			$this->stmtGetInstitutionFromID = $this->db_connection->prepare("SELECT * FROM institutions WHERE ID = ?");
			$this->stmtGetUserFromUsername = $this->db_connection->prepare("SELECT * FROM users WHERE sUsername = ?");
			$this->stmtGetGroupFromID = $this->db_connection->prepare("SELECT * FROM groups WHERE ID = ?");
			$this->stmtGetGroupsFromUserID = $this->db_connection->prepare("SELECT `GroupID` FROM `usertogroup` WHERE `UserID`= ?");
			$this->stmtGetModuleFromID = $this->db_connection->prepare("SELECT * FROM modules WHERE ID = ?");
            $this->stmtGetProfilePicFromUserID = $this->db_connection->prepare("SELECT sProfilePicture FROM users WHERE ID = ?");
            $this->stmtGetIDFromUsername = $this->db_connection->prepare("SELECT ID FROM users WHERE sUsername = ? ");
            $this->stmtGetModuleImageFromID = $this->db_connection->prepare("SELECT sPfadBild FROM modules WHERE ID = ?");
           
            $this->stmtCountInstitutions = $this->db_connection->prepare("SELECT COUNT(ID) FROM institutions");
            $this->stmtCountUsers = $this->db_connection->prepare("SELECT COUNT(ID) FROM users");
            $this->stmtCountInstitutionsFromUser = $this->db_connection->prepare("SELECT COUNT(InstitutionID) FROM usertoinstitution WHERE UserID = ?");
            $this->stmtGetAllInstitutions = $this->db_connection->prepare("SELECT * FROM institutions");
            $this->stmtGetAllUsers = $this->db_connection->prepare("SELECT * FROM users");
            $this->stmtgetInstitutionsFromUserID = $this->db_connection->prepare("SELECT InstitutionID FROM usertoinstitution WHERE UserID = ?");
            //----- UPDATES ------
            $this->stmtSetProfilePic = $this->db_connection->prepare("UPDATE users SET sProfilePicture = ? WHERE ID = ?");
            $this->stmtSetFortschrittFromUserinGroup = $this->db_connection->prepare("UPDATE usertogroup SET iFortschritt = iFortschritt + 1                                                                               WHERE GroupID = ? AND UserID = ?");
            $this->stmtSetFortschrittforallUsersinGroup = $this->db_connection->prepare("UPDATE usertogroup SET iFortschritt = ? WHERE GroupID = ? AND iFortschritt < ?");
            $this->stmtSetUsernameFromID = $this->db_connection->prepare("UPDATE users SET sUsername = ? WHERE ID = ?");
            $this->stmtSetFirstNameFromID = $this->db_connection->prepare("UPDATE users SET sFirstName = ? WHERE ID = ?");
            $this->stmtSetLastNameFromID = $this->db_connection->prepare("UPDATE users SET sLastName = ? WHERE ID = ?");
            $this->stmtSetEMailFromID = $this->db_connection->prepare("UPDATE users SET sEMail = ? WHERE ID = ?");
            $this->stmtSetPasswordFromID = $this->db_connection->prepare("UPDATE users SET sPassword = ? WHERE ID = ?");
            $this->stmtSetModuleNameFromID = $this->db_connection->prepare("UPDATE modules SET sName = ? WHERE ID = ?");
            $this->stmtSetModuleDescriptionFromID = $this->db_connection->prepare("UPDATE modules SET sDescription = ? WHERE ID = ? ");
            $this->stmtSetChapterTextFromID = $this->db_connection->prepare("UPDATE chapters SET sText = ? WHERE ID = ?");
            $this->stmtSetModuleImageFromID = $this->db_connection->prepare("UPDATE modules SET sPfadBild = ? WHERE ID = ?");
            $this->stmtAcceptHandIn = $this->db_connection->prepare("UPDATE handins SET bIsAccepted = 1 WHERE UserID = ? AND GroupID = ? AND bIsAccepted = 0");
            
            //----- INSERTS -----
            $this->stmtaddUser = $this->db_connection->prepare("INSERT INTO users (sUsername,sFirstName,sLastName,sEMail,sHashedPassword,sProfilePicture) VALUES                                                     (?,?,?,?,?,'../ProfilePics/generalpic.png')");
            $this->stmtaddHandIn = $this->db_connection->prepare("INSERT INTO handins (UserID,GroupID,ChapterID,sText) VALUES (?,?,?,?)");
            $this->stmtaddInstitution = $this->db_connection->prepare("INSERT INTO institutions (sName,bIsDeleted) VALUES (?,0)");
            $this->stmtaddChaptertoModule = $this->db_connection->prepare("INSERT INTO chapters (iIndex,sTitle,sText,ModulID) VALUES (?,?,?,?)"); 
            
            //----- DELETES -----
            $this->stmtdeleteUser = $this->db_connection->prepare("DELETE FROM users WHERE ID = ?");
            $this->stmtdeleteHandIn = $this->db_connection->prepare("DELETE FROM handins WHERE ID = ?");
        }
		
        public function replaceTags ($_sContent){
            
             $sMyDocument = str_replace(' ', '&nbsp;',  str_replace('\r','<br>', str_replace('\n','<br>', str_replace("]\n",']' ,str_replace('<', '&lt;', str_replace('>', '&gt;', $_sContent))))));
            
            $sTags =$this->query('SELECT sTagFrom,sTagInto,sParam FROM transcribedtags');  
            for ($x = 0; $x <= mysqli_num_rows($sTags);$x++) {
                $aRow =  mysqli_fetch_assoc($sTags);
                
                if ($aRow['sParam']=="") {

                    $sMyDocument =  str_replace ($aRow['sTagFrom'],$aRow['sTagInto'],$sMyDocument);
                    
                } else {
                    
                    $iOffset = 0;
                    $i = 1;
                    $myCount =substr_count($sMyDocument, $aRow['sTagFrom']); 
                    if ($myCount > 0){
                        while ( $i <= $myCount ){ 
                            if ($i > 0){$iOffset = strpos($sMyDocument,$aRow['sTagFrom']);}
                            $i = $i +1;
                            if (substr($sMyDocument,$iOffset+strlen($aRow['sTagFrom']) ,1)=='{'){

                                $sMyParam = substr($sMyDocument,strpos($sMyDocument,'{' , $iOffset)+1,strpos ($sMyDocument,'}',$iOffset)-1-strpos($sMyDocument,'{' , $iOffset));
                                $sTest = $sMyParam;
                                $iParamOffset = 0;
                                $sMyWorkStr ='';
                                for ($e = 0; $e <= substr_count($sMyParam, ';')+1;$e++){                               
                                    if (strpos($sMyParam,';') > 0) {    
                                        $sOneParam = substr($sMyParam,$iParamOffset,strpos($sMyParam,';',$iParamOffset)-$iParamOffset);
                                        $iParamOffset = strpos($sMyParam,$sOneParam,$iParamOffset);
                                        $sMyParam = preg_replace('/'.preg_quote($sOneParam .';', '/').'/','',$sMyParam);
                                    } else {
                                        $sOneParam = substr($sMyParam,0,strlen($sMyParam)-1);
                                        $sMyParam= preg_replace('/'.preg_quote($sOneParam, '/').'/','',$sMyParam);
                                    }
                                    if (strpos('#' . $aRow['sParam'],substr($sOneParam,0,strpos($sOneParam,'=')))> 0){
                                        $ishortOffset = strpos($sOneParam,'"')+1;   
                                        $sMyWorkStr = $sMyWorkStr . substr($sOneParam,0,strpos($sOneParam,'"',$ishortOffset)+1) . ' '; 
                                    }

                                }
                            }
                            $sToReplace = $aRow['sTagInto'];
                            $sTrReplace = str_replace('>',' ' . $sMyWorkStr,$sToReplace);
                            $sTrReplace = $sTrReplace . ">";

                            $iReplaceOffset = strpos($sMyDocument,'}',$iOffset)+1-$iOffset;
                            $sMyDocument = str_replace(substr($sMyDocument,$iOffset,$iReplaceOffset),$sTrReplace,$sMyDocument);
                        }
                    }
                }
            }
       
            return $sMyDocument;
        }
           
        public function isUsernameTaken($sUsername){
            $this->stmtisUsernameTaken->bind_param("s",$sUsername);	
			$this->stmtisUsernameTaken->execute();
			$res = $this->stmtisUsernameTaken->get_result();
            $iNumberOfUsersWithThisUsername = mysqli_num_rows($res);
			if ($iNumberOfUsersWithThisUsername != 0) {
                return true;
            } else {
                return false;  
            }
        }
        
        public function isEmailTaken($sEmail){
			$this->stmtisEmailTaken->bind_param("s",$sEmail);	
			$this->stmtisEmailTaken->execute();
			$res = $this->stmtisEmailTaken->get_result();
			$iAmountOfThisEmail = mysqli_num_rows($res);
            if ($iAmountOfThisEmail != 0) {
                return true;
            } else {
                return false;
            }
        }
        
        public function isViableUsername($ID,$Username){
            $this->stmtisUsernameFromID->bind_param("s",$Username);
            $this->stmtisUsernameFromID->execute();
            $res = $this->stmtisUsernameFromID->get_result();
            $row = mysqli_fetch_array($res);
            if (mysqli_num_rows($res)==0) {
                return true;
            } elseif ($row['ID']==$ID){
                return true;
            } else {
                return false;
            }
        }
        
        public function isViableEMail($ID,$EMail){
            $this->stmtisEMailFromID->bind_param("s",$EMail);
            $this->stmtisEMailFromID->execute();
            $res = $this->stmtisEMailFromID->get_result();
            $row = mysqli_fetch_array($res);
            if (mysqli_num_rows($res)==0) {
                return true;
            } elseif ($row['ID']==$ID){
                return true;
            } else {
                return false;
            }
        }
        
        public function isUserinGroup($UserID,$GroupID){
            $this->stmtisUserinGroup->bind_param("ii",$UserID,$GroupID); 
            $this->stmtisUserinGroup->execute();
            $res = $this->stmtisUserinGroup->get_result();
            if (mysqli_num_rows($res)==1){
                return true;
            } else {
                return false;
            }
        }
        
        public function isTrainerofGroup($UserID,$GroupID){
            $this->stmtisTrainerofGroup->bind_param("ii",$UserID,$GroupID); 
            $this->stmtisTrainerofGroup->execute();
            $res = $this->stmtisTrainerofGroup->get_result();
            if (mysqli_num_rows($res)==1){
                return true;
            } else {
                return false;
            }
        }
		
		public function isNewHandIn($UserID,$GroupID){
			$this->stmtisNewHandIn->bind_param("ii",$UserID,$GroupID);
			$this->stmtisNewHandIn->execute();
			$res = $this->stmtisNewHandIn->get_result();
			if (mysqli_num_rows($res) == 1) {
				return true;
			} else{
				return false;			
			}
		}
        
        public function addUser($Username,$FirstName,$LastName,$Email,$Password){
            $this->stmtaddUser->bind_param("sssss",$Username,$FirstName,$LastName,$Email,$Password);
            $this->stmtaddUser->execute();
        }
        
        public function addInstitution($sName){
            $this->stmtaddInstitution->bind_param("s",$sName);
            $this->stmtaddInstitution->execute();
        }
        
        public function addHandIn($UserID,$GroupID,$ChapterID,$Text){
            $this->stmtaddHandIn->bind_param("iiis",$UserID,$GroupID,$ChapterID,$Text);
            $this->stmtaddHandIn->execute();
        }
        
        public function addChaptertoModule($Index,$Title,$Text,$ModulID){
            $this->stmtaddChaptertoModule->bind_param("issi",$Index,$Title,$Text,$ModulID);
            $this->stmtaddChaptertoModule->execute();
        }
        
        public function getIDFromUsername($Username){
            $this->stmtGetIDFromUsername->bind_param("s",$Username); 
            $this->stmtGetIDFromUsername->execute();
            $res = $this->stmtGetIDFromUsername->get_result();
            if (mysqli_num_rows($res)==1){
                $row = mysqli_fetch_array($res);
                    return $row['ID'];
            } else {
                throw new exception('Mehr als ein User mit dieser ID');        
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
        
        public function getProfilePicFromID($ID){
            $this->stmtGetProfilePicFromUserID ->bind_param("i",$ID);
            $this->stmtGetProfilePicFromUserID->execute();
            $res = $this->stmtGetProfilePicFromUserID->get_result();
            if (mysqli_num_rows($res)==1){
                $row = mysqli_fetch_array($res);
                    return $row['sProfilePicture'];
            } else {
                throw new exception('Mehr als ein User mit dieser ID');        
            }
        }
        
        public function getModuleImageFromID($ID){
            $this->stmtGetModuleImageFromID->bind_param("i",$ID);
            $this->stmtGetModuleImageFromID->execute();
        }
        
        public function countInstitutions(){
            $this->stmtCountInstitutions->execute();
            $res = $this->stmtCountInstitutions->get_result();
            $row = mysqli_fetch_array($res);
            return $row['COUNT(ID)'];
        }
        
        public function countUsers(){
            $this->stmtCountUsers->execute();
            $res = $this->stmtCountUsers->get_result();
            $row = mysqli_fetch_array($res);
            return $row['COUNT(ID)'];
        }
        
        public function countInstitutionsFromUser($UserID){
            $this->stmtCountInstitutionsFromUser->bind_param("i",$UserID);
            $this->stmtCountInstitutionsFromUser->execute();
            $res = $this->stmtCountInstitutionsFromUser->get_result();
            $row = mysqli_fetch_array($res);
            return $row['COUNT(InstitutionID)'];
        }
        
        public function getAllInstitutions(){
            $this->stmtGetAllInstitutions->execute();
            $res = $this->stmtGetAllInstitutions->get_result();
            $anz = $this->countInstitutions();
            $row = [];
            $ins = [];
            for ($i=0;$i<$anz;$i++){
                $row[$i] = mysqli_fetch_array($res); 
                $ins[$i] = new Institution($row[$i]['ID'],$row[$i]['sID'],$row[$i]['sName'],$row[$i]['bIsDeleted']);
            } 
            
            return $ins;
            
        }
        
        public function getAllUsers(){
            $this->stmtGetAllUsers->execute();
            $res = $this->stmtGetAllUsers->get_result();
            $anz = $this->countUsers();
            $row = [];
            $users = [];
            for ($i=0;$i<$anz;$i++){
                $row[$i] = mysqli_fetch_array($res);
                $users[$i] =  new User($row[$i]['ID'],$row[$i]['sID'],$row[$i]['sUsername'],$row[$i]['sFirstName'],
                                   $row[$i]['sLastName'],$row[$i]['sEMail'],$row[$i]['sHashedPassword'],
                                   $row[$i]['sProfilePicture'],$row[$i]['bIsVerified'],$row[$i]['bIsAdmin'],$row[$i]['bIsOnline']); 
            }
            
            return $users;
            
        }
        
        public function getInstitutionsFromUserID($UserID){
            $this->stmtgetInstitutionsFromUserID->bind_param("i",$UserID);
            $this->stmtgetInstitutionsFromUserID->execute();
            $res = $this->stmtgetInstitutionsFromUserID->get_result();
            $anz = $this->countInstitutionsFromUser($UserID);
            $row = [];
            $ins = [];
            for ($i=0;$i<$anz;$i++){
                $row[$i] = mysqli_fetch_array($res); 
                $ins[$i] = $row[$i]['InstitutionID'];
            } 
            
            return $ins;
        }
        
        public function setProfilePic($sProfilePic,$ID){
            $this->stmtSetProfilePic->bind_param("si",$sProfilePic,$ID);
            $this->stmtSetProfilePic->execute();  
        }
        
        public function setFortschrittFromUserinGroup($UserID,$GroupID ){
            $this->stmtSetFortschrittFromUserinGroup->bind_param("ii",$GroupID,$UserID);
            $this->stmtSetFortschrittFromUserinGroup->execute();
        }
        
        public function setFortschrittforallUsersinGroup($Fortschritt,$GroupID){
            $this->stmtSetFortschrittforallUsersinGroup->bind_param("iii",$Fortschritt,$GroupID,$Fortschritt);
            $this->stmtSetFortschrittforallUsersinGroup->execute();
        }
        
        public function setUsernameFromID($Username,$ID){
            $this->stmtSetUsernameFromID->bind_param("si",$Username,$ID);
            $this->stmtSetUsernameFromID->execute();
        }
        
        public function setFirstNameFromID($FirstName,$ID){
            $this->stmtSetFirstNameFromID->bind_param("si",$FirstName,$ID);
            $this->stmtSetFirstNameFromID->execute();
        }
        
        public function setLastNameFromID($LastName,$ID){
            $this->stmtSetLastNameFromID->bind_param("si",$LastName,$ID);
            $this->stmtSetLastNameFromID->execute();
        }
        
        public function setEMailFromID($Email,$ID){
            $this->stmtSetEMailFromID ->bind_param("si",$Email,$ID);
            $this->stmtSetEMailFromID ->execute();
        }
        
        public function setPasswordFromID($Password,$ID){
            $this->stmtSetPasswordFromID->bind_param("si",$Password,$ID);
            $this->stmtSetPasswordFromID->execute();
        }
        
        public function setModuleNameFromID($ModuleName,$ID){
            $this->stmtSetModuleNameFromID->bind_param("si",$ModuleName,$ID);
            $this->stmtSetModuleNameFromID->execute();
        }
        
        public function setModuleDescriptionFromID($ModuleDescription,$ID){
            $this->stmtSetModuleDescriptionFromID->bind_param("si",$ModuleDescription,$ID);    
            $this->stmtSetModuleDescriptionFromID->execute();
        }
        
        public function setChapterTextFromID($Text,$ID){
            $this->stmtSetChapterTextFromID->bind_param("si",$Text,$ID);
            $this->stmtSetChapterTextFromID->execute();
        }
        
        public function setModuleImageFromID($PfadBild,$ID){
            $this->stmtSetModuleImageFromID->bind_param("si",$PfadBild,$ID);
            $this->stmtSetModuleImageFromID->execute();
        }
        
        public function acceptHandIn($UserID,$GroupID){
            $this->stmtAcceptHandIn->bind_param("ii",$UserID,$GroupID);
            $this->stmtAcceptHandIn->execute();
        }
        
        public function deleteUser($ID){
            $this->stmtdeleteUser->bind_param("i",$ID);
            $this->stmtdeleteUser->execute();
        }
        
        public function deleteHandIn($ID){
            $this->stmtdeleteHandIn->bind_param("i",$ID);
            $this->stmtdeleteHandIn->execute();
        }
		
    }


    global $ODB;
    $ODB = new Database();  

?>
