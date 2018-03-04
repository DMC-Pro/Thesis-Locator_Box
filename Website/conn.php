
<?php
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "lifeboxthesis2018";
	$dbname = "thesis";
	$conn = new mysqli ($dbhost, $dbuser, $dbpass, $dbname);		
	if ($conn->connect_error) 
		{die("Connection failed: " . $conn->connect_error);}
?>	
