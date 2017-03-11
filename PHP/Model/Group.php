<?php
class Group {
    private $ID;
    private $ModulID;
    private $InstitutionsID;
    private $sName;
    private $bIsDeleted;
    public $teilnehmer = array(); //as User + fortschritt+ istrainer

    public function __construct($ID, $ModulID, $InstitutionsID, $sName, $bIsDeleted, $teilnehmer) {
        $this->ID = $ID;
        $this->ModulID = $ModulID;
        $this->InstitutionsID = $InstitutionsID;
        $this->sName = $sName;
        $this->bIsDeleted = $bIsDeleted;
        while (($row = mysqli_fetch_row($teilnehmer)) != NULL) {

            $this->teilnehmer[] = new Teilnehmer($row[0], $row[1], $row[2], $row[3],
                $row[4], $row[5], $row[6], $row[7], $row[8],
                $row[9], $row[10], $row[11], $row[12]);
        }
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