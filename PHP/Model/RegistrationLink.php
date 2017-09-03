<?php
class RegistrationLink {
    private $ID;
    private $GroupID;
    private $Link;
    private $StartDate;
    private $EndDate;

    public function __construct($ID,$GroupID,$Link,$StartDate,$EndDate) {
        $this->ID = $ID;
        $this->GroupID = $GroupID;
        $this->Link = $Link;
        $this->StartDate = $StartDate;
        $this->EndDate = $EndDate;
    }

    public function getID() {
        return $this->ID;
    }
     public function getGroupID() {
        return $this->GroupID;
    }
        public function getLink() {
        return $this->Link;
    }
        public function getStartDate() {
        return $this->StartDate;
    }
        public function getEndDate() {
        return $this->EndDate;
    }



}