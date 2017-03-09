<?php
    class Database
    {
        private $db_connection;
        public function __construct(){
            $this->db_connection = mysqli_connect('localhost', 'root', '', 'iiigel');   
        }
        
        public function query($statement){
            return mysqli_query($this->db_connection, $statement); 
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
         $res = $this->query("SELECT * FROM Users WHERE Users.ID ='$ID'");
            if (mysqli_num_rows($res)==1){
                $row = mysqli_fetch_array($res);
                    return new group($row['ID'],$row['ModulID'],$row['InstitutionsID'],$row['sName'],
                                    $row['bIsDeleted']);
            } else {
                throw new exception('Mehr als eine Gruppe mit dieser ID');        
            }
        }
    }

    class User
    {
        private $ID;
        private $sID;
        private $sUsername;
        private $sFirstName;
        private $sLastName;
        private $sEMail;
        private $sHashedPassword;
        private $sProfilePicture;
        private $bIsVerified;
        private $bIsAdmin;
        private $bIsOnline;
        
        public function __construct($ID,$sID,$sUsername,$sFirstName,$sLastName,$sEMail,$sHashedPassword,$sProfilePicture,$bIsVerified,$bIsAdmin,$bIsOnline){
            $this->ID = $ID;
            $this->sID = $sID;
            $this->sUsername = $sUsername;
            $this->sFirstName = $sFirstName;
            $this->sLastName = $sLastName;
            $this->sEMail = $sEMail;
            $this->sHashedPassword = $sHashedPassword;
            $this->sProfilePicture = $sProfilePicture;
            $this->bIsVerified = $bIsVerified;
            $this->bIsAdmin = $bIsAdmin;
            $this->bIsOnline = $bIsOnline;
        }
        public function getID(){
            return $this->ID;
        }
        public function getsID(){
            return $this->sID;
        }
        public function getsUsername(){
            return $this->sUsername;
        }
        public function getsFirstName(){
            return $this->sFirstName;
        }
        public function getsLastName(){
            return $this->sLastName;
        }
        public function getsEMail(){
            return $this->sEMail;
        }
        public function getsHashedPassword(){
            return $this->sHashedPassword;
        }
        public function getsProfilePicture(){
            return $this->sProfilePicture;
        }
        public function getbIsVerified(){
            return $this->bIsVerified;
        }
        public function getbIsAdmin(){
            return $this->bIsAdmin;
        }
        public function getbIsOnline(){
            return $this->bIsOnline;
        }
        public function verifyPassword($hashedPassword){
            return password_verify($hashedPassword, $this->sHashedPassword);
        }
    }

    class group{
        private $ID;
        private $ModulID;
        private $InstitutionsID;
        private $sName;
        private $bIsDeleted;
        private $Teilnehmer; //as User + fortschritt+ istrainer
        public function __construct($ID,$ModulID,$InstitutionsID,$sName,$bIsDeleted){
            $this->ID = $ID;
            $this->ModulID = $ModulID;
            $this->InstitutionsID = $InstitutionsID;
            $this->sName = $sName;
            $this->bIsDeleted = $bIsDeleted;
            $res = $ODB->query("SELECT * FROM users INNER JOIN usertogroup ON users.ID = usertogroup.UserID WHERE usertogroup.GroupID = ".$this->ID." ORDER BY users.sFirstName ASC");
            $Teilnehmer = mysqli_fetch_array($res);
        }
        public function getID(){
            return $this->ID;
        }
         public function getModulID(){
            return $this->ModulID;
        }
         public function getInstitutionsID(){
            return $this->InstitutionsID;
        }
         public function getsName(){
            return $this->sName;
        }
         public function getbIsDeleted(){
            return $this->bIsDeleted;
        }
    }

    class module{
        private $ID;
        private $sID;
        private $sName;
        private $sDescription;
        private $sLanguage;
        private $sIcon;
        private $bIsDeleted;
        private $bIsLive;
        private $chapter;
        public function __construct($ID,$sID,$sName,$sDescriptionsLanguage,$sIcon,$bIsDeleted,$bIsLive){
            $this->ID= $ID;
            $this->sID= $sID;
            $this->sName= $sName;
            $this->sDescription= $sDescription;
            $this->sLanguage= $sLanguage;
            $this->sIcon= $sIcon;
            $this->bIsDeleted= $bIsDeleted;
            $this->bIsLive= $bIsLive;
            $res= $ODB->query("SELECT * FROM chapters WHERE ModulID = ".$this->ID." ORDER BY iIndex");
            
            
            while ($row = mysqli_fetch_row($res) != NULL){
                array_push($chapter,new chapter($row['ID'],$row['sID'],$row['iIndex'],$row['sTitle'],
                                                $row['sText'],$row['sNote'],$row['ModulID'],$row['bInterpreter'],$row['bIsMandatoryHandIn'],
                                                $row['bIsLive'],$row['bLiveInterpretation'],$row['bShowCloud'],$row['bIsDeleted']));
            }
            
            
             
              
            } 
        
           
            
    }

    class chapter{	
        private $ID;
        private $sID;
        private $iIndex;
        private $sTitle;
        private $sText;
        private $sNote;
        private $ModulID;
        private $bInterpreter;
        private $bIsMandatoryHandIn;
        private $bIsLive;
        private $bLiveInterpretation;
        private $bShowCloud;
        private $bIsDeleted;
        public function __construct($ID,$sID,$iIndex,$sTitle,$sText,$sNote,$ModulID,$bInterpret,$bIsMandato,$bIsLive,$bLiveInter,$bShowCloud,$bIsDeleted){
            $this->ID= $ID;
            $this->sID= $sID;
            $this->iIndex= $iIndex;
            $this->sTitle= $sTitle;
            $this->sText= $sText;
            $this->sNote= $sNote;
            $this->ModulID= $ModulID;
            $this->bInterpreter= $bInterpreter;
            $this->bIsMandatoryHandIn= $bIsMandatoryHandIn;
            $this->bIsLive= $bIsLive;
            $this->bLiveInterpretation= $bLiveInterpretation;
            $this->bShowCloud= $bShowCloud;
            $this->bIsDeleted= $bIsDeleted;  
        }
    }
    
        
 global $ODB;
 $ODB = new Database();    
?>