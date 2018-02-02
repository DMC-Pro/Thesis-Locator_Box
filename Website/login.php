<!DOCTYPE html>
<html>
<head>
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
<div id="maindiv">
	<div id="div2" align="center">
		<img src="http://localhost/thesis/res/logo.png" id="logo" height="50px" width="50px">
		<form method="get" name="myForm" onsubmit="return validateForm()" action="http://localhost/thesis/login2.php"> 
			</p>
			Username:<input name="user" type="text" value=""/></p>
			Password:<input name="pass" type="password" value=""/></p>
			<button name="log" type="submit">Login</button></p>
		</form>
	</div>
</div>
</body>
</html>
