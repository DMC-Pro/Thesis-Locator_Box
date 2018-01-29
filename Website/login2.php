<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="http://localhost/thesis/res/login.css"/>
	<script>
		function validateForm() 
		{var x= document.forms["myForm"]["user"].value;
		var y= document.forms["myForm"]["pass"].value;
		if (x=="" && y=="") {
		alert("Please fill out form");
        return false;}
		else if (x=="") {
		alert("Username must be filled out");
        return false;}
		else if (y=="") {
		alert("Password must be filled out");
        return false;}
		}
	</script>
	<?php
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpass = "lifeboxthesis2018";
		$dbname = "thesis";
		$count=0;
		$conn = new mysqli ($dbhost, $dbuser, $dbpass, $dbname);		
		if ($conn->connect_error) 
			{die("Connection failed: " . $conn->connect_error);} 
		$user = $_GET["user"];
		$pass = $_GET["pass"];
		$query = "SELECT username, password FROM users";
		$result = $conn->query($query);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				if($row["username"]==$user && $row["password"]==$pass)
				{header("location:http://localhost/thesis/index.php?user=".$user);
				break;}
				else if ($row["username"]!=$user && $row["password"]==$pass)
				{echo '<p id="alert">'.'Incorrect Username.'.'</p>';
				break;}
				else if ($row["username"]==$user && $row["password"]!=$pass)
				{echo '<p id="alert">'.'Incorrect password.'.'</p>';
				break;}
				else if( $count< $result->num_rows)
				{$count=$count+1;}
				if ($count == $result->num_rows)
				{echo '<p id="alert">'.'User not found.'.'</p>';
				break;}
			}
		}

	$conn->close();
	?>
</head>
<body>
<div id="maindiv">
	<div id="div2" align="center">
		<form method="get" name="myForm" onsubmit="return validateForm()" action="http://localhost/thesis/login2.php"> 
			</p>
			Username:<input name="user" type="text" value=""/></p>
			Password:<input name="pass" type="password" value=""/></p>
			<button name="log" type="submit">Login</button></p>
		</form>
	</div>
</body>
</html>