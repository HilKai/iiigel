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

    public function __construct($ID, $sID, $sName, $sDescription, $sLanguage, $sIcon, $bIsDeleted, $bIsLive, $chapters) {

        $this->ID = $ID;
        $this->sID = $sID;
        $this->sName = $sName;
        $this->$sDescription = $sDescription;
        $this->sLanguage = $sLanguage;
        $this->sIcon = $sIcon;
        $this->bIsDeleted = $bIsDeleted;
        $this->bIsLive = $bIsLive;

        while (($row = mysqli_fetch_row($chapters)) != NULL) {
            $this->chapter[] = new Chapter($row[0], $row[1], $row[2], $row[3],
                $row[4], $row[5], $row[6], $row[7], $row[8],
                $row[9], $row[10], $row[11], $row[12]);
        }


    }


}