<?php
	 ob_start();
	 session_start();
	 $myPage = file_get_contents('../HTML/trainerModulview.html');
	 include_once("database.php");
	include_once("Navigation.php");
	 $grey = "#ddd";
	 $red = "#ff0000";
	 $color = $grey;

	 $handIn=[];
    
    
    $currentGroupID = $_GET['groupID'];
    $myUserID = $_SESSION['user'];
    $_SESSION['lastDeletedUser'] = 0;
	 
	 // if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: ../index.php");
	  exit;
	 }

    if( !$ODB->isTrainerofGroup($_SESSION['user'],$currentGroupID) ) {
	  header("Location: ../index.php");
	  exit;
	 }   
    

    //
    $myGroup = $ODB->getGroupFromID($currentGroupID);//AL Zieht aus der Datenbank, in welcher Gruppe und welchem Modul man ist
    $myModule = $ODB->getModuleFromID($myGroup->getModulID());
    $search = array('%Gruppenname%', '%Institution%', '%GroupID%');
    $replace = array($myGroup->getsName(), $ODB->getInstitutionFromID($myGroup-> getInstitutionsID())->getsName(), $currentGroupID);
    $myPage = str_replace($search,$replace,$myPage);
	
	$myPage = str_replace('%Navigation%',getNavigation(),$myPage);//AL Navigationsleitse wird zusammengebaut
    // select modul member details
    $toAdd = "";

    $myModuleID = $myModule->getID();
    if ($_POST){
        
        if(isset($_POST['levelUpforAll'])){
            $ODB->setFortschrittforallUsersinGroup($_POST['levelUpforAll'],$currentGroupID);
            header("Refresh:0");   
        }
        if(isset($_POST['levelUp'])){
            for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
                if($myGroup->teilnehmer[$i]->getID() ==  $_POST['levelUp']) {
                    if($myGroup->teilnehmer[$i]->getiFortschritt()<sizeof($myModule->chapter)-1){
                        $id =$myGroup ->teilnehmer[$i]->getID();
                        $ODB->setFortschrittFromUserinGroup($id,$currentGroupID);
                        header("Refresh:0");     
                    }
                }
            }
        }
        if ( isset($_POST['removeUserFromGroupButton']) ) {
            
            for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
                if($myGroup->teilnehmer[$i]->getID() ==  $_POST['removeUserFromGroupButton']) {
                    if($myGroup->teilnehmer[$i]->getiFortschritt()<sizeof($myModule->chapter)-1){
                        $id =$myGroup ->teilnehmer[$i]->getID();
                        if($id!=$myUserID){
                        $_SESSION['lastDeletedUser'] = $id;
                        $ODB->removeUserFromGroup($id,$currentGroupID);
                        header("Refresh:0"); 
                        }
                    }
                }
            }
        }
        
        if(isset($_POST['acceptHandIn'])){
            for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
                if($myGroup->teilnehmer[$i]->getID() ==  $_POST['acceptHandIn']) {
                        $id =$myGroup ->teilnehmer[$i]->getID();
                        $ODB->acceptHandIn($id,$currentGroupID);
						$ODB->setFortschrittFromUserinGroup($id,$currentGroupID);
                        header("Refresh:0");     
                }
            }
            
        }
		
		 if(isset($_POST['rejectHandIn'])){
            for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){   
                if($myGroup->teilnehmer[$i]->getID() ==  $_POST['rejectHandIn']) {
                        $id =$myGroup ->teilnehmer[$i]->getID();
                        $ODB->rejectHandIn($id,$currentGroupID);
                        header("Refresh:0");     
                }
            }
            
        }
        
   }
 
    
   for ($i=0; $i< sizeof($myGroup->teilnehmer);$i++){ //AL Setzt die TN Liste zusammen
	   		$handIn[$myGroup->teilnehmer[$i]->getID()] = $ODB->getHandIn($myGroup->teilnehmer[$i]->getID(), $myGroup->getID());
        	$myRow = file_get_contents('../HTML/trainerModulTablerow.html');
            $search = array('%Prename%', '%Lastname%', '%Progress%', '%ProgressPercent%','%ID%');
            $replace = array($myGroup ->teilnehmer[$i]->getsFirstName(), $myGroup ->teilnehmer[$i]->getsLastName(), $myGroup->teilnehmer[$i]->getiFortschritt()+1, (100*($myGroup->teilnehmer[$i]->getiFortschritt()))/(sizeof($myModule->chapter)-1),$myGroup->teilnehmer[$i]->getID());
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
       
    
    }

//Link setzen im Toggle Button
   
        
        $link = "../PHP/ChapterView.php?moduleID=".$myModuleID."&chapterID=0&groupID=".$currentGroupID;
        $search = array('%TogglelinkK%');
        $replace = array($link);
        $myPage = str_replace($search,$replace,$myPage); 
    
       
    
    $myPage=str_replace('%Tablerow%',$toAdd,$myPage);

    //create DropDown Chapter List
    $toAdd = ""; //Hinzugefügter HTML Code
   for ($i=0; $i< sizeof($myModule->chapter);$i++){  
            $myRow = file_get_contents('../HTML/ChapterDropdownListItem.html');
            $search = array('%ChapterTitle%');
            $replace = array($myModule ->chapter[$i]->getsTitle());
            $myRow = str_replace($search,$replace,$myRow);
        
        $toAdd = $toAdd . $myRow;
       
     
       
        
    }
        $myPage=str_replace('%ChapterDropDownItems%',$toAdd,$myPage);

    $toAdd = "";
    $aktiveLinks = $ODB->getAllAktiveLinksFromGroup($myGroup->getID());
    for ($i=0; $i< sizeof($aktiveLinks);$i++){  
            $myRow = file_get_contents('../HTML/trainerModulviewAktiveLinktitem.html');
            $search = array('%LinkString%','%endDate%');
            $replace = array($aktiveLinks[$i] ->getLink(),$aktiveLinks[$i]->getEndDatum());
            $myRow = str_replace($search,$replace,$myRow);
        $toAdd = $toAdd . $myRow;        
    }

	//alle TN für Dropdown
	$add = '';
    $myUsers= $ODB->getAllUsersFromInstitutionNotInGroup($myGroup->getInstitutionsID(),intval($_GET['groupID']));
	for ($a=0;$a<sizeof($myUsers);$a++){
		$myRow = file_get_contents('../HTML/AdminGroupUserListitem.html');
      
        $search = array('%Vorname%','%Nachname%','%UserID%');
		$replace = array($myUsers[$a]->getsFirstName(),$myUsers[$a]->getsLastName(),$myUsers[$a]->getID());  
        $myRow = str_replace($search,$replace,$myRow);
        $add = $add . $myRow;
       
	}

    $myPage=str_replace('%linkrow%',$toAdd,$myPage);
	$myPage=str_replace('%handIn%',json_encode($handIn),$myPage); //setzt Hand In Text ins Modal
	$myPage = str_replace("%allTN%",$add,$myPage);  //alle TN in Dropdown

    if (isset($_POST['HinzuButton'])){ 
        $ODB->addUsertoGroup($_POST['UserID'],$currentGroupID);
        header ("Location: ../PHP/trainerModulview.php?groupID=".$currentGroupID);
    }
    
    if (isset($_POST['ErstellButton'])){
        if (!$ODB->isGroupLinkTaken($_POST['input'])) {
            $ODB->addGroupInvitationLink($_POST['input'],$currentGroupID,$_POST['start'],$_POST['end']);
            header("Location: ../PHP/trainerModulview.php?groupID=".$currentGroupID);
        } else {
            $error = true;
            $GroupLinkError = "Dieser Gruppencode ist bereits vergeben.";
            header("Location: ../PHP/trainerModulview.php?groupID=".$currentGroupID);
        }
    }
    
    echo $myPage;  
?>

<div id="myLinkModal" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" onclick="deleteDanger()">&times;</button>
									<h4 class="modal-title">Neuen Link/Gruppencode erstellen</h4>
								</div>
								<form id="myForm2" action="" method="post" autocomplete="off">
									<div class="modal-body">
										<div class="form-group">
											<label for="exampleInputPrename">Link/Gruppencode</label>
											<input id="pw1" type="text" name="input" class="form-control form" value="">
                                            <span class="text-danger"><?php if(isset($GroupLinkError)) echo $GroupLinkError; ?> </span>
                                            <div id="DateInput" class="row">
												<div id="Startdatum Input" class="col-md-6">
													<label for="exampleInputPrename" class="dateInput" >Startdatum</label> <br>
                                            		<input class=" addForm dateInput" name="start" id="startdate" type="date" value=""  placeholder="Startdatum" style="margin-top: 10px">
												</div>
												
												<div id="Entdatum Input" class="col-md-6">
													<label class ="dateInput" for="exampleInputPrename">Enddatum</label> <br>
                                            		<input name="end" id="enddate" type="date" value="" class="addForm dateInput" placeholder="Enddatum">
												</div>
											</div>
										
											<span id="passError" class="text-danger"></span>
										</div>

									</div>
									<!---type="submit" value="text" name="newPass" -->
								
								<div class="modal-footer">
									<button type= "submit" name = "ErstellButton" id="ModalBtn" class="btn btn-default">Erstellen</button>
								</div>
                                </form>
							</div>

						</div>
					</div>