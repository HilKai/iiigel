<?php

class HandIn {
    private $ID;
    private $sID;
    private $Date;
    private $UserID;
    private $GroupID;
    private $ChapterID;
    private $bIsAccepted;
    private $bIsUnderReview;
    private $isRejected;
    private $sText;
    
    public function __construct($ID, $sID, $Date, $UserID, $GroupID, $ChapterID, $bIsAccepted, $bIsUnderReview, $isRejected, $sText) {
        $this->ID = $ID;
        $this->sID = $sID;
        $this->Date = $Date;
        $this->UserID = $UserID;
        $this->GroupID = $GroupID;
        $this->ChapterID = $ChapterID;
        $this->bIsAccepted = $bIsAccepted;
        $this->bIsUnderReview = $bIsUnderReview;
        $this->bIsRejected = $isRejected;
        $this->sText = $sText;
    }
    
    public function getID() {
        return $this->ID;
    }

    public function getsID() {
        return $this->sID;
    }

    public function getDate() {
        return $this->Date;
    }

    public function getUserID() {
        return $this->UserID;
    }

    public function getGroupID() {
        return $this->GroupID;
    }

    public function getChapterID() {
        return $this->ChapterID;
    }

    public function getbIsAccepted() {
        return $this->bIsAccepted;
    }

    public function getbIsUnderReview() {
        return $this->bIsUnderReview;
    }

    public function getisRejected() {
        return $this->isRejected;
    }

    public function getsText() {
        return $this->sText;
    }
}
?>