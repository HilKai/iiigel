<?php
class Chapter {
    private $ID;
    private $sID;
    private $iIndex;
    private $sTitle;
    private $sText;
    private $sNote;
    private $ModulID;
    private $bInterpreter;
    private $bIsMandatoryHandIn;
    private $bIsLive;
    private $bLiveInterpretation;
    private $bShowCloud;
    private $bIsDeleted;

    public function __construct($ID, $sID, $iIndex, $sTitle, $sText, $sNote, $ModulID, $bInterpreter, $bIsMandatoryHandIn, $bIsLive, $bLiveInterpretation, $bShowCloud, $bIsDeleted) {
        $this->ID = $ID;
        $this->sID = $sID;
        $this->iIndex = $iIndex;
        $this->sTitle = $sTitle;
        $this->sText = $sText;
        $this->sNote = $sNote;
        $this->ModulID = $ModulID;
        $this->bInterpreter = $bInterpreter;
        $this->bIsMandatoryHandIn = $bIsMandatoryHandIn;
        $this->bIsLive = $bIsLive;
        $this->bLiveInterpretation = $bLiveInterpretation;
        $this->bShowCloud = $bShowCloud;
        $this->bIsDeleted = $bIsDeleted;
    }

    public function getID() {
        return $this->ID;
    }

    public function getsID() {
        return $this->sID;
    }

    public function getiIndex() {
        return $this->iIndex;
    }

    public function getsTitle() {
      return $this->sTitle;
    }

    public function getsText() {
       return $this->sText;
    }

    public function getsNote() {
        return $this->sNote;
    }

    public function getModulID() {
        return $this->ModulID;
    }

    public function getbInterpreter() {
        return $this->bInterpreter;
    }

    public function getbIsMandatoryHandIn() {
        return $this->bIsMandatoryHandIn;
    }

    public function getbIsLive() {
        return $this->bIsLive;
    }

    public function getbLiveInterpretation() {
        return $this->bLiveInterpretation;
    }

    public function getbShowCloud() {
        return $this->bShowCloud;
    }

    public function getbIsDeleted() {
        return $this->bIsDeleted;
    }

}