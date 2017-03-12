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
    public $chapter = array();

    public function __construct($ID, $sID, $sName, $sDescription, $sLanguage, $sIcon, $bIsDeleted, $bIsLive, $aChapters) {

        $this->ID = $ID;
        $this->sID = $sID;
        $this->sName = $sName;
        $this->sDescription = $sDescription;
        $this->sLanguage = $sLanguage;
        $this->sIcon = $sIcon;
        $this->bIsDeleted = $bIsDeleted;
        $this->bIsLive = $bIsLive;
        $this->chapters = $aChapters;
    }


}