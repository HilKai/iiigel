<?php
class Module {
    private $ID;
    private $sID;
    private $sName;
    private $sDescription;
    private $sLanguage;
    private $sIcon;
    private $bIsDeleted;
    private $bIsLive;
    public  $chapter = array();

    public function __construct($ID, $sID, $sName, $sDescription, $sLanguage, $sIcon, $bIsDeleted, $bIsLive, $aChapters) {

        $this->ID = $ID;
        $this->sID = $sID;
        $this->sName = $sName;
        $this->sDescription = $sDescription;
        $this->sLanguage = $sLanguage;
        $this->sIcon = $sIcon;
        $this->bIsDeleted = $bIsDeleted;
        $this->bIsLive = $bIsLive;
        $this->chapter = $aChapters;
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
    
    public function getsDescription() {
        return $this->sDescription;
    }
    
    public function getsLanguage() {
        return $this->sLanguage;
    }
    
    public function getsIcon() {
        return $this->sIcon;
    }
    
    public function getbIsDeleted() {
        return $this->bIsDeleted;
    }
    
    public function getbIsLive() {
        return $this->bIsLive;
    }
    
    public function getchapterbyIndex($index) {
        return $this->chapter[$index];
    }
    
    public function getChapterTextbyIndex($index) {
        if (sizeof($this->chapter)> $index){
            return $this->chapter[$index]->getsText();
        } else {
            return null;
        }     
    }
    
    public function getChapterHeadlineByIndex($index) {
        if (sizeof($this->chapter)> $index){
            return $this->chapter[$index]->getsTitle();
        } else {
            return null;
        }
    }
    
   
}