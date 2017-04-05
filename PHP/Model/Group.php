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
    
    public function getTrainer(){ //returns the Trainer of a Group
        $myTrainer =[];
        for ($i=0;$i< sizeof($this->teilnehmer);$i++){
            if ($this->teilnehmer[$i]->getbIsTrainer() == true){
                $myTrainer[] = $this->teilnehmer[$i];
            }
        }
        return $myTrainer;
    }
    
    public function getProgressFromUserID($ID){
        for ($i=0;$i< sizeof($this->teilnehmer);$i++){
            if ($this->teilnehmer[$i]->getID() == $ID){
                return $this->teilnehmer[$i]->getiFortschritt();   
            }
        }
      
    }
    
    public function getAverageProgressFromGroup(){
        $levelcounter = 0;
        for ($i=0;$i< sizeof($this->teilnehmer);$i++){
            if ($this->teilnehmer[$i]->getbisTrainer() == false ){
                $levelcounter = $levelcounter + $this->teilnehmer[$i]->getiFortschritt(); 
            }
        }
        return $levelcounter/sizeof($this->teilnehmer);
    }
}