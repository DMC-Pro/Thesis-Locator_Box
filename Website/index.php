<html>
<head>
	<link rel="stylesheet" type="text/css" href="http://localhost/thesis/res/style.css" />
	<script>
		function drop1() {document.getElementById("dropdown1").classList.toggle("show");}
		function drop2() {document.getElementById("dropdown2").classList.toggle("show");}
		function drop3() {document.getElementById("dropdown3").classList.toggle("show");}
	</script>
	<?php
	function curPageURL() 
		{$pageURL = 'http';
		$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") 
			{$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];}
			else {$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];}
		return $pageURL;}
		
	$result = curPageURL();
	if ($result=="http://localhost/thesis/index.php")
		{header("location:http://localhost/thesis/login.php");}
	?>
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
		<?php
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpass = "lifeboxthesis2018";
		$dbname = "thesis";
		$count=0;
		$conn = new mysqli ($dbhost, $dbuser, $dbpass, $dbname);		
		if ($conn->connect_error) 
			{die("Connection failed: " . $conn->connect_error);}
		$query = "SELECT device_status, device_id FROM devices";
		$result = $conn->query($query);
		if ($result->num_rows > 0) 
			{while($row = $result->fetch_assoc()) 
				{if ($row["device_status"]=="Active")
					{echo '<button class="dropbtn">'.$row["device_id"]."</button>"."</p>";}}} 
		else {echo "0 results";}
		?>
	</div>
	<div id="center">
	</div>
	<div id="respondent">
		<p><strong>Available Respondents</strong></p>
		<div class="dropdown">
			<button onclick="drop1()" class="dropbtn">Respondent1</button>
			<div id="dropdown1" class="dropdown-content">
			<?php 
				$query = "SELECT device_status, device_id FROM devices";
				$result = $conn->query($query);
				if ($result->num_rows > 0) 
					{while($row = $result->fetch_assoc()) 
						{if ($row["device_status"]=="Active")
					{		echo '<a href="#">'.$row["device_id"]."</button>"."</a>";}}} 
				else {echo "0 results";}
			?>
			</div>
		</div></p>
		<div class="dropdown">
			<button onclick="drop2()" class="dropbtn">Respondent2</button>
			<div id="dropdown2" class="dropdown-content">
				<?php 
				$query = "SELECT device_status, device_id FROM devices";
				$result = $conn->query($query);
				if ($result->num_rows > 0) 
					{while($row = $result->fetch_assoc()) 
						{if ($row["device_status"]=="Active")
					{		echo '<a href="#">'.$row["device_id"]."</button>"."</a>";}}} 
				else {echo "0 results";}
			?>
			</div>
		</div></p>
		<div class="dropdown">
			<button onclick="drop3()" class="dropbtn">Respondent3</button>
			<div id="dropdown3" class="dropdown-content">
				<?php 
				$query = "SELECT device_status, device_id FROM devices";
				$result = $conn->query($query);
				if ($result->num_rows > 0) 
					{while($row = $result->fetch_assoc()) 
						{if ($row["device_status"]=="Active")
					{		echo '<a href="#">'.$row["device_id"]."</button>"."</a>";}}} 
				else {echo "0 results";}
			?>
			</div>
		</div>
	</div>
	<div class="footer">
	Copyright©2018 Life Locator Box Thesis Group, All rights reserved.
	</div>
</body>
</html>
