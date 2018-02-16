<html>
<head>
	<link rel="stylesheet" type="text/css" href="res/style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
			var pos = new google.maps.LatLng(a,b);
			map.setCenter(pos);
			marker.setPosition(pos);
		});
		google.maps.event.addDomListener(document.getElementById('dev2'), 'click', function () {
			var a= document.getElementById('lat2').innerHTML;
			var b= document.getElementById('lng2').innerHTML;
			var pos = new google.maps.LatLng(a,b);
			map.setCenter(pos);
			marker.setPosition(pos);
		});}
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA90ZPwAZuHCBfyQRJYPUNwTm__vSc_dEg&callback=initMap">
    </script>
	<script>
		function ResDev1() {
			$.get("test2.php", function(data) {
			$("#dropdown1").html(data);
			window.setTimeout(ResDev1, 5000);
			});
		}
		function ResDev2() {
			$.get("r2.php", function(data) {
			$("#dropdown2").html(data);
			window.setTimeout(ResDev2, 5000);
			});
		}
		function ActiveDev() {
			$.get("test.php", function(data) {
			$("#devices").html(data);
			window.setTimeout(ActiveDev, 5000);
			});
		}	
	</script>
	<script>
		function send(dev, id) {
			var xhttp;    
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var x=document.getElementById("response");
					x.style.display = "block";
					x.innerHTML = this.responseText;
				}
			};
			xhttp.open("GET", "test1.php?a="+dev+"&b="+id, true);
			xhttp.send();
		}
		
	</script>
	<?php
	function curPageURL() 
		{$pageURL = 'http';
		$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") 
			{$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];}
			else {$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];}
		return $pageURL;}
		
	$res = curPageURL();
	if ($res=="http://localhost/thesis/index.php")
		{header("location:http://localhost/thesis/login.php");}
	if ($res=="http://localhost/thesis/res/index.php")
		{header("location:http://localhost/thesis/index.php");}
	if ($res=="http://localhost/thesis/interlinks/index.php")
		{header("location:http://localhost/thesis/index.php");}
	
	?>
</head>
<body onload="ActiveDev(), ResDev1(), ResDev2()">
	<div class="navbar" id="head">
		<img src="res/logo.png" id="logo" height="50px" width="50px">
		<a id="map" href="#">Map</a>
		<form action="login.php"> 
			<button id="out" type="submit">Log out</button>
		</form>
		
		<?php
			echo "<h3>".$_GET["user"]."</h3>";
		?>
		
	</div>
	<div id="devices">
	</div>
	<div id="center">
	</div>
	<div id="respondent">
		<p><strong>Available Respondents</strong></p>
		<ul>
		<?php
			include "conn.php";
		
			$q = "SELECT rescue_team_status, rescue_team_current_task FROM rescue_team WHERE id=1";
			$r = $conn->query($q);
			if ($r->num_rows > 0) 
				{while($row = $r->fetch_assoc()) 
					{if ($row["rescue_team_status"]=="On Route")
						{echo '<li id="1" class="onroute">';}
					else {
						echo '<li id="1" class="standby">';}
				}}
		?>
		<div class="dropdown" onload="ResDev()">
			<button onclick="drop1()" class="dropbtn2">Santolan Volunteer 01</button>
			<div id="dropdown1" class="dropdown-content"> 
			</div>
		</div></p></li>
		<?php
			include "conn.php";
		
			$q = "SELECT rescue_team_status, rescue_team_current_task FROM rescue_team WHERE id=2";
			$r = $conn->query($q);
			if ($r->num_rows > 0) 
				{while($row = $r->fetch_assoc()) 
					{if ($row["rescue_team_status"]=="On Route")
						{echo '<li id="2" class="onroute">';}
					else {
						echo '<li id="2" class="standby">';}
				}}
		?>
		<div class="dropdown">
			<button onclick="drop2()" class="dropbtn2">Santolan Rescue 02</button>
			<div id="dropdown2" class="dropdown-content">
			</div>
		</div></p></li>
	</div>
	<div id="response">
	</div>
	<div class="footer">
	Copyright©2018 Life and Body Locator Box Thesis Group, All rights reserved.
	</div>
</body>
</html>
