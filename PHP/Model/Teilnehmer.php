<?php

class Teilnehmer { //nur für User in Modulen
    //ToDo: shouldn't that be a subclass of User?
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
 
    public function __construct($ID, $sID, $sUsername, $sFirstName, $sLastName, $sEMail, $sHashedPassword, $sProfilePicture, $bIsVerified, $bIsAdmin, $bIsOnline, $iFortschritt, $bIsTrainer) {
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

    public function getiFortschritt() {
        return $this->iFortschritt;
    }

    public function getbIsTrainer() {
        return $this->bIsTrainer;
    }
}