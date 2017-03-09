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
         $res = $this->query("SELECT * FROM Groups WHERE Groups.ID ='$ID'");
            if (mysqli_num_rows($res)==1){
                $row = mysqli_fetch_array($res);
                    return new group($row['ID'],$row['ModulID'],$row['InstitutionsID'],$row['sName'],
                                    $row['bIsDeleted'],
                                     $this->query("SELECT users.ID,users.sID,users.sUsername,users.sFirstName,users.sLastName,users.sEMail,users.sHashedPassword,users.sProfilePicture,users.bIsVerified,users.bIsAdmin,users.bIsOnline,usertogroup.iFortschritt,usertogroup.bIsTrainer FROM users INNER JOIN usertogroup ON users.ID = usertogroup.UserID  WHERE usertogroup.GroupID = ".$ID." ORDER BY users.sFirstName ASC"));
            } else {
                throw new exception('Mehr als eine Gruppe mit dieser ID');        
            }
        }
        public function getModuleFromID($ID){
            $res = $this->query("SELECT * FROM Modules WHERE Modules.ID ='$ID'");
            if (mysqli_num_rows($res)==1){
                $row = mysqli_fetch_array($res);
                    return new Module($row['ID'],$row['sID'],$row['sName'],$row['sDescription'],$row['sLanguage'],$row['sIcon'],$row['bIsDeleted'],$row['bIsLive'],
                                     $this->query("SELECT * FROM chapters WHERE ModulID = ".$ID." ORDER BY iIndex")
                                     );
            } else {
                throw new exception('Mehr als ein Modul mit dieser ID');        
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
    
    class teilnehmer{ //nur für User in Modulen
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
        private $iFortschritt;
        private $bIsTrainer;
        
         public function __construct($ID,$sID,$sUsername,$sFirstName,$sLastName,$sEMail,$sHashedPassword,$sProfilePicture,$bIsVerified,$bIsAdmin,$bIsOnline,$iFortschritt,$bIsTrainer){
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
            $this->iFortschritt = $iFortschritt;
            $this->bIsTrainer = $bIsTrainer;
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
        
        public function getiFortschritt(){
            return $this->iFortschritt;
        }
        public function getbIsTrainer(){
            return $this->bIsTrainer;
        }
    }

    class group{
        private $ID;
        private $ModulID;
        private $InstitutionsID;
        private $sName;
        private $bIsDeleted;
        public $teilnehmer = array(); //as User + fortschritt+ istrainer
        public function __construct($ID,$ModulID,$InstitutionsID,$sName,$bIsDeleted,$teilnehmer){
            $this->ID = $ID;
            $this->ModulID = $ModulID;
            $this->InstitutionsID = $InstitutionsID;
            $this->sName = $sName;
            $this->bIsDeleted = $bIsDeleted;
            while (($row = mysqli_fetch_row($teilnehmer)) != NULL){
             
               $this->teilnehmer[] = new teilnehmer($row[0],$row[1],$row[2],$row[3],
                                                $row[4],$row[5],$row[6],$row[7],$row[8],
                                                $row[9],$row[10],$row[11],$row[12]);
            }
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
        public $chapter = array();
        public function __construct($ID,$sID,$sName,$sDescription,$sLanguage,$sIcon,$bIsDeleted,$bIsLive,$chapters){
   
            $this->ID= $ID;
            $this->sID= $sID;
            $this->sName= $sName;
            $this->$sDescription= $sDescription;
            $this->sLanguage= $sLanguage;
            $this->sIcon= $sIcon;
            $this->bIsDeleted= $bIsDeleted;
            $this->bIsLive= $bIsLive;
            
            while (($row = mysqli_fetch_row($chapters)) != NULL){
                $this->chapter[] =new chapter($row[0],$row[1],$row[2],$row[3],
                                                $row[4],$row[5],$row[6],$row[7],$row[8],
                                                $row[9],$row[10],$row[11],$row[12]); 
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
        public function __construct($ID,$sID,$iIndex,$sTitle,$sText,$sNote,$ModulID,$bInterpreter,$bIsMandatoryHandIn,$bIsLive,$bLiveInterpretation,$bShowCloud,$bIsDeleted){
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
        public function getID(){
            return $this->ID;
        }
          public function getsID(){
            return $this->sID;
        }
          public function getiIndex(){
            return $this->iIndex;
        }
          public function getsTitle(){
            return $this->sTitle;
        }
          public function getsText(){
            return $this->sText;
        }
          public function getsNote(){
            return $this->sNote;
        }
          public function getModulID(){
            return $this->ModulID;
        }
          public function getbInterpreter(){
            return $this->bInterpreter;
        }
          public function getbIsMandatoryHandIn(){
            return $this->bIsMandatoryHandIn;
        }
          public function getbIsLive(){
            return $this->bIsLive;
        }
          public function getbLiveInterpretation(){
            return $this->bLiveInterpretation;
        }
          public function getbShowCloud(){
            return $this->bShowCloud;
        }
          public function getbIsDeleted(){
            return $this->bIsDeleted;
        }
        
    }
    
        
 
    global $ODB;
    $ODB = new Database();  
?>