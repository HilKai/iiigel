<script>
	function setNewPass() {
		$pw1 = document.getElementById("pw1").value;
		$pw2 = document.getElementById("pw2").value;
		$.ajax({
                type: "POST",
                url: "setPassword.php",
                data: { userID:"%userID%", passwort1:$pw1, passwort2:$pw2},
			 	success: function(result){
					//todo Interpretieren des Ergebnisses
					alert(result);
					}
				
         });
	}
</script>