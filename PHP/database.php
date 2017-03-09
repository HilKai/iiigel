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
        private $Teilnehmer; //as User
        public function __construct($ID,$ModulID,$InstitutionsID,$sName,$bIsDeleted){
            $this->ID = $ID;
            $this->ModulID = $ModulID;
            $this->InstitutionsID = $InstitutionsID;
            $this->sName = $sName;
            $this->bIsDeleted = $bIsDeleted;
            $res = $ODB->query('SELECT * FROM users INNER JOIN usertogroup ON users.ID = usertogroup.UserID WHERE usertogroup.GroupID = '$ID'');
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
    
        
 global $ODB;
 $ODB = new Database();    
?>