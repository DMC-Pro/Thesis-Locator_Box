<html>
<head>
	<link rel="stylesheet" type="text/css" href="http://localhost/thesis/res/style.css" />
	<script>
		function drop1() {document.getElementById("dropdown1").classList.toggle("show");}
		function drop2() {document.getElementById("dropdown2").classList.toggle("show");}
		function drop3() {document.getElementById("dropdown3").classList.toggle("show");}
	</script>
</head>
<body>
	<div class="navbar" id="head">
		<img src="http://localhost/thesis/res/logo.png" id="logo" height="50px" width="50px">
		<a id="map" href="#map">Map</a>
		<form action="http://localhost/thesis/test1.html"> 
			<button id="out" type="submit">Log out</button>
		</form>
		
		<?php
			echo "<h3>".$_GET["user"]."</h3>";
		?>
		
	</div>
	<div id="devices">
		<p><strong>Active Devices</strong></p>
		<button class="dropbtn">Device1</button></p>
		<button class="dropbtn">Device2</button>
	</div>
	<div id="center">
	</div>
	<div id="respondent">
		<p><strong>Available Respondents</strong></p>
		<div class="dropdown">
			<button onclick="drop1()" class="dropbtn">Respondent1</button>
			<div id="dropdown1" class="dropdown-content">
				<a href="#">Location1</a>
				<a href="#">Location2</a>
				<a href="#">Location3</a>
			</div>
		</div></p>
		<div class="dropdown">
			<button onclick="drop2()" class="dropbtn">Respondent2</button>
			<div id="dropdown2" class="dropdown-content">
				<a href="#">Location1</a>
				<a href="#">Location2</a>
				<a href="#">Location3</a>
			</div>
		</div></p>
		<div class="dropdown">
			<button onclick="drop3()" class="dropbtn">Respondent3</button>
			<div id="dropdown3" class="dropdown-content">
				<a href="#">Location1</a>
				<a href="#">Location2</a>
				<a href="#">Location3</a>
			</div>
		</div>
	</div>
	<div class="footer">
	Copyright©2018 Life Locator Box Thesis Group, All rights reserved.
	</div>
</body>
</html>