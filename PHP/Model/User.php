<?php

class User {
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

    public function __construct($ID, $sID, $sUsername, $sFirstName, $sLastName, $sEMail, $sHashedPassword,
                                $sProfilePicture, $bIsVerified, $bIsAdmin, $bIsOnline) {
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

    public function getID() {
        return $this->ID;
    }

    public function getsID() {
        return $this->sID;
    }

    public function getsUsername() {
        return $this->sUsername;
    }

    public function getsFirstName() {
        return $this->sFirstName;
    }

    public function getsLastName() {
        return $this->sLastName;
    }

    public function getsEMail() {
        return $this->sEMail;
    }

    public function getsHashedPassword() {
        return $this->sHashedPassword;
    }

    public function getsProfilePicture() {
        return $this->sProfilePicture;
    }

    public function getbIsVerified() {
        return $this->bIsVerified;
    }

    public function getbIsAdmin() {
        return $this->bIsAdmin;
    }

    public function getbIsOnline() {
        return $this->bIsOnline;
    }

    public function verifyPassword($hashedPassword) {
        return password_verify($hashedPassword, $this->sHashedPassword);
    }
}