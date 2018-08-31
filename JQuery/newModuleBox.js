<script>
	function loadAction() {
		document.getElementById("myForm").action = "editProfile.php?userID=%userID%";
		document.getElementById("myForm2").action = "editProfile.php?userID=%userID%";
	
		if (%userID% != %sessionID%) document.getElementById("ZurückButton").action = "AdminUserView.php";
	}
	
	function setNewPass() {
		$pw1 = document.getElementById("pw1").value;
		$pw2 = document.getElementById("pw2").value;
		$.ajax({
                type: "POST",
                url: "setPassword.php",
                data: { userID:"%userID%", passwort1:$pw1, passwort2:$pw2},
			 	success: function(result){
					if (result == "") {
						$('#myModal').modal('hide');
					} 
					if (result == "Die beiden Passwörter stimmen nicht überein.") document.getElementById("passError").innerHTML = "Die beiden 			Passwörter stimmen nicht überein.";
					if (result == "Das eingegebene Passwort ist zu kurz. Es muss länger als 6 Zeichen sein.")					
						document.getElementById("passError").innerHTML = "Das eingegebene Passwort ist zu kurz. Es muss länger als 6 Zeichen sein.";
					if (result == "Bitte wiederholen sie ihr Passwort") document.getElementById("passError").innerHTML = "Bitte wiederholen sie ihr 	Passwort" ;
					if (result == "Bitte geben Sie ein Passwort ein.") document.getElementById("passError").innerHTML = "Bitte geben Sie ein Passwort 	  ein.";
				}
				
         });
	}

	function deleteDanger() {
		document.getElementById("passError").innerHTML = "";
		document.getElementById("pw1").value = "";
		document.getElementById("pw2").value = "";
		
	}
</script>
