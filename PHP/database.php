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
                    return new Group($row['ID'],$row['ModulID'],$row['InstitutionsID'],$row['sName'],
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


global $ODB;
    $ODB = new Database();  
?>