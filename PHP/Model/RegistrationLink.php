<?php
class RegistrationLink {
    private $ID;
    private $Link;
    private $GroupID;
    private $StartDatum;
    private $EndDatum;

    public function __construct($ID,$Link,$GroupID,$StartDatum,$EndDatum) {
        $this->ID = $ID;
        $this->Link = $Link;
        $this->GroupID = $GroupID;
        $this->StartDate = $StartDatum;
        $this->EndDate = $EndDatum;
    }

    public function getID() {
        return $this->ID;
    }
    public function getLink() {
        return $this->Link;
    }
     public function getGroupID() {
        return $this->GroupID;
    }
        public function getStartDatum() {
        return $this->StartDate;
    }
        public function getEndDatum() {
        return $this->EndDate;
    }



}