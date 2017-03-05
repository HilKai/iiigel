 <?php 

	$db_connection = mysqli_connect('localhost', 'root', '', 'iiigel');
	
	if(!$db_connection){
		echo('Keine Verbindung mit der Datenbank möglich');
	}
	
	function iiigel_query($query){
		global $db_connection;
		return mysqli_query($db_connection, $query);
	}
 
 
 ?>