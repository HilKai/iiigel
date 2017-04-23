<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../bootstrap-3.3.7-dist\bootstrap-3.3.7-dist\css\bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="../Styles\editProfile.css" type="text/css">
        <!-- Schrift -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    </head>

    <body>

        <div id="WrappingContainer" class="container">

            <div id="ProfileContainer" class="row">

                <div class="col-md-3 noPadding">

                    <img id="ProfilePic" class="img-responsive img-circle" src="../ProfilePics/profilePic.jpg" alt="ProfilePicture">

                </div>
                
                <div id="ProfileTextContainer" class="col-md-8">

                    <div id="" class="row">
                        <div class="col-md-12 noPadding">
                            <h1 id="Heading"> Profil bearbeiten</h1>
                        </div>
                    </div>
                    
                    <div id="" class="row">
                        <div class="col-md-6 noPadding">
                            <form action="upload.php" method="post" enctype="multipart/form-data">
                               <div class="form-group">
                                    <label for="exampleInputFile"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Profilbild hochladen</label>
                                    <input type="file" name="datei" value="Hochladen" id="exampleInputFile">
                               </div> 
                            </form>
                        </div>
                        
                        <div class="col-md-2 noPadding">
                            <button id="PasswortButton" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Passwort ändern</button>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 noPadding">
                            <form>
                              <div class="form-group">
                                    <label for="exampleInputPrename">Vorname</label>
                                    <input type="text" name="vorname" class="form-control form" placeholder="%Vorname%" value="<?php if(isset($vorname)) echo $vorname; ?>">
                                    <span class="text-danger"><?php if(isset($vornameError)) echo $vornameError; ?></span>
                              </div>
                              <div class="form-group">
                                    <label for="exampleInputLastname">Nachname</label>
                                    <input type="text" name="nachname" class="form-control form" placeholder="%Nachname%" value="<?php if(isset($nachname)) echo $nachname; ?>">
                                    <span class="text-danger"><?php if(isset($nachnameError)) echo $nachnameError; ?></span>
                              </div> 
                            </form>    
                        </div>
                        <div class="col-md-6 noPadding">
                            <form>
                              <div class="form-group">
                                    <label for="exampleInputUsername">Benutzername</label>
                                    <input type="text" name="username" class="form-control form" placeholder="%UserName%" value="<?php if(isset($username)) echo $username; ?>">
                                    <span class="text-danger"><?php if(isset($usernameError)) echo $usernameError; ?></span>
                              </div>
                              <div class="form-group">
                                    <label for="exampleInputMail"><span class="glyphicon glyphicon-envelope"></span> E-Mail Adresse</label>
                                    <input type="email"  name="email" class="form-control form" placeholder="%EMail%"  value="<?php if(isset($email)) echo $email; ?>">
                                    <span class="text-danger"><?php if(isset($emailError)) echo $emailError; ?></span>
                              </div>
                            </form>    
                        </div>
                    </div>
                    
                    <div id="" class="row">
                        <div class="col-md-2 noPadding">
                                <a  href="../HTML/userOverview.html"><button id="PinkButton" class="btn btn-default" href="userOverview.html">Speichern</button></a>
                            </div>
                            <div class="col-md-2 noPadding">
                                <a  href="../HTML/userOverview.html"><button id="Button" type="submit" name="btn-save" class="btn btn-default">Abbrechen</button></a>
                            </div>
                        </div>
                    </div>
                    
                </div> 
    
            </div>
            
        </div>    

    </body>

</html>