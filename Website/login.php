<!DOCTYPE html>
<html>
<head>
	<?php
		if (session_status() == PHP_SESSION_NONE) {
		session_start();
		}	
		include "conn.php";
		$message = "";
		if(isset($_POST['submit'])) {
			$query="SELECT operator_password FROM operators WHERE operator_username='".$_POST['user']."'";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$password = $row["operator_password"];
					$verify= password_verify($_POST['pass'], $password);
					if($verify == 1){
						$_SESSION['user'] = $_POST['user'];
						$message="";
						header("location:http://localhost/thesis/index.php");
					}
					else{
						$message="Incorrect password.";
					}
				}
			}
			else {
				$message="Username not found.";
			}
		}	
	?>
	<link rel="stylesheet" type="text/css" href="http://localhost/thesis/res/login.css" />
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
</head>
<body>
	<div id="div2" align="center">
		<img src="http://localhost/thesis/res/logo.png" id="logo" height="50px" width="50px">
		<form method="POST"> 
			</p>
			Username:<input name="user" type="text" value=""/></p>
			Password:<input name="pass" type="password" value=""/></p>
			<p style="color:red;"><?php echo $message ?></p>
			<input type="submit" name="submit" value="submit" /></br>
		</form>
	</div>
</body>
</html>