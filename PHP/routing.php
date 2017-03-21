<?php

/*
 * This script is the entry-point for all uris that are not pointing to files in the file-system
 * you have access to the uri that the client requestet by $_SERVER['REQUEST_URI']
 */
require_once "database.php";

$sRequestedUri = $_SERVER['REQUEST_URI'];

//split it by '/', ignoring empty parts at beginning and end:
$aRequestUriParts = explode('/', trim($sRequestedUri, '/'));

// ignore the first element, if its 'iiigel' and throw it away:
if ($aRequestUriParts[0] === 'iiigel') {
    array_shift($aRequestUriParts);
}

// now do what you like with this data
// switch is not nice, but just to show whats possible:
switch ($aRequestUriParts[0]){
    case 'Kapitelansicht':
        // URI-Format: Kapitelansicht/[module_slug]/chapter-index
        $sModuleSlug = $aRequestUriParts[1];
        $oModule = $ODB->getModuleBySlug($sModuleSlug);
        $iChapterIndex = $aRequestUriParts[2];

        // now that the variables are set up, give control to the script:
        require_once "ChapterView.php";
    break;
    default:
        echo 'PageNotFound!';
    break;
}
