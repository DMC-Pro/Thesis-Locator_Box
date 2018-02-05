<html>
<head>
	<link rel="stylesheet" type="text/css" href="http://localhost/thesis/res/style.css" />
	<script>
		function drop1() {document.getElementById("dropdown1").classList.toggle("show");}
		function drop2() {document.getElementById("dropdown2").classList.toggle("show");}
		function drop3() {document.getElementById("dropdown3").classList.toggle("show");}
	
		function initMap() {
        var uluru = {lat: 14.5979292, lng: 121.01075560000004};
        var map = new google.maps.Map(document.getElementById('center'), {
          zoom: 18,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
		google.maps.event.addDomListener(document.getElementById('dev1'), 'click', function () {
			var a= document.getElementById('lat1').innerHTML;
			var b= document.getElementById('lng1').innerHTML;
			var x= a.substr(0, a.length -1);
			var y= b.substr(0, b.length -1);
			if (a.substr(a.length -1, a.length) == "S" && b.substr(b.length -1, b.length) == "W")
				{var pos = new google.maps.LatLng(-x,-y);}
			else if (a.substr(a.length -1, a.length) == "N" && b.substr(b.length -1, b.length) == "W")
				{var pos = new google.maps.LatLng(x,-y);}
			else if (a.substr(a.length -1, a.length) == "S" && b.substr(b.length -1, b.length) == "E")
				{var pos = new google.maps.LatLng(-x,y);}
			else if (a.substr(a.length -1, a.length) == "N" && b.substr(b.length -1, b.length) == "E")
				{var pos = new google.maps.LatLng(x,y);}
			map.setCenter(pos);
			marker.setPosition(pos);
		});
		google.maps.event.addDomListener(document.getElementById('dev2'), 'click', function () {
			var a= document.getElementById('lat2').innerHTML;
			var b= document.getElementById('lng2').innerHTML;
			var x= a.substr(0, a.length -1);
			var y= b.substr(0, b.length -1);
			if (a.substr(a.length -1, a.length) == "S" && b.substr(b.length -1, b.length) == "W")
				{var pos = new google.maps.LatLng(-x,-y);}
			else if (a.substr(a.length -1, a.length) == "N" && b.substr(b.length -1, b.length) == "W")
				{var pos = new google.maps.LatLng(x,-y);}
			else if (a.substr(a.length -1, a.length) == "S" && b.substr(b.length -1, b.length) == "E")
				{var pos = new google.maps.LatLng(-x,y);}
			else if (a.substr(a.length -1, a.length) == "N" && b.substr(b.length -1, b.length) == "E")
				{var pos = new google.maps.LatLng(x,y);}
			map.setCenter(pos);
			map.setCenter(pos);
			marker.setPosition(pos);
		});}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA90ZPwAZuHCBfyQRJYPUNwTm__vSc_dEg&callback=initMap">
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
	if ($result=="http://localhost/thesis/res/index.php")
		{header("location:http://localhost/thesis/index.php");}
	if ($result=="http://localhost/thesis/interlinks/index.php")
		{header("location:http://localhost/thesis/index.php");}
	?>
</head>
<body>
	<div class="navbar" id="head">
		<img src="http://localhost/thesis/res/logo.png" id="logo" height="50px" width="50px">
		<a id="map" href="#map">Map</a>
		<form action="http://localhost/thesis/login.php"> 
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
		$count = 1;
		$conn = new mysqli ($dbhost, $dbuser, $dbpass, $dbname);		
		if ($conn->connect_error) 
			{die("Connection failed: " . $conn->connect_error);}
		$query = "SELECT device_status, device_id, device_latitude, device_longitude FROM devices";
		$result = $conn->query($query);
		if ($result->num_rows > 0) 
			{while($row = $result->fetch_assoc()) 
				{if ($row["device_status"]=="Active")
					{echo '<button class="dropbtn" id="dev'.$count.'">'.$row["device_id"]."</button>"."</p>";
					echo '<p class="hidden" id="lat'.$count.'">'.$row["device_latitude"].'</p>';
					echo '<p class="hidden" id="lng'.$count.'">'.$row["device_longitude"].'</p>';
					$count=$count+1;}}} 
		else {echo "0 results";}
		?>
	</div>
	<div id="center">
	</div>
	<div id="respondent">
		<p><strong>Available Respondents</strong></p>
		<div class="dropdown">
			<button onclick="drop1()" class="dropbtn2">Respondent1</button>
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
			<button onclick="drop2()" class="dropbtn2">Respondent2</button>
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
			<button onclick="drop3()" class="dropbtn2">Respondent3</button>
			<div id="dropdown3" class="dropdown-content">
				<?php
				$query = "SELECT device_status, device_id FROM devices";
				$result = $conn->query($query);
				if ($result->num_rows > 0) 
					{while($row = $result->fetch_assoc()) 
						{if ($row["device_status"]=="Active")
							{echo '<a href="#">'.$row["device_id"]."</a>";}}} 
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
