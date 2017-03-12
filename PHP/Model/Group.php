<?php
class Group {
    private $ID;
    private $ModulID;
    private $InstitutionsID;
    private $sName;
    private $bIsDeleted;
    public $teilnehmer = array(); //as User + fortschritt+ istrainer

    public function __construct($ID, $ModulID, $InstitutionsID, $sName, $bIsDeleted, $aTeilnehmer) {
        $this->ID = $ID;
        $this->ModulID = $ModulID;
        $this->InstitutionsID = $InstitutionsID;
        $this->sName = $sName;
        $this->bIsDeleted = $bIsDeleted;
        $this->teilnehmer = $aTeilnehmer;
    }

    public function getID() {
        return $this->ID;
    }

    public function getModulID() {
        return $this->ModulID;
    }

    public function getInstitutionsID() {
        return $this->InstitutionsID;
    }

    public function getsName() {
        return $this->sName;
    }

    public function getbIsDeleted() {
        return $this->bIsDeleted;
    }
}