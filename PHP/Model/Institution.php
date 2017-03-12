<?php
class Institution {
    private $ID;
    private $sID;
    private $sName;
    private $bIsDeleted;

    public function __construct($ID, $sID, $sName, $bIsDeleted) {
        $this->ID = $ID;
        $this->sID = $sID;
        $this->sName = $sName;
        $this->bIsDeleted = $bIsDeleted;
    }

    public function getID() {
        return $this->ID;
    }

    public function getsID() {
        return $this->sID;
    }

    public function getsName() {
        return $this->sName;
    }

    public function getbIsDeleted() {
        return $this->bIsDeleted;
    }
}