<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="res/style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script id="aids" async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA90ZPwAZuHCBfyQRJYPUNwTm__vSc_dEg&callback=initMap">
    </script>
	<script>
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
		}
		
		function cLoc(x) {
			if (x == 1) {
				var a= document.getElementById('lat1').innerHTML;
				var b= document.getElementById('lng1').innerHTML;
				var uluru = new google.maps.LatLng(a,b);
				var map = new google.maps.Map(document.getElementById('center'), {
				zoom: 18,
				center: uluru
				});
				var marker = new google.maps.Marker({
				position: uluru,
				map: map
				});
				var cntr1= 1;
				function follow1() {
					a= document.getElementById('lat1').innerHTML;
					b= document.getElementById('lng1').innerHTML;
					var pos = new google.maps.LatLng(a,b);
					marker.setPosition(pos);
					if(cntr1==12) {
						map.setCenter(pos);
						cntr1=1;}
					else {
						cntr1++;}	
					}
				setInterval(follow1, 2000);}
			else if (x == 2) {
				var a= document.getElementById('lat2').innerHTML;
				var b= document.getElementById('lng2').innerHTML;
				var uluru = new google.maps.LatLng(a,b);
				var map = new google.maps.Map(document.getElementById('center'), {
				zoom: 18,
				center: uluru
				});
				var marker = new google.maps.Marker({
				position: uluru,
				map: map
				});
				var cntr=1;
				function follow2() {
					var a= document.getElementById('lat2').innerHTML;
					var b= document.getElementById('lng2').innerHTML;
					var pos = new google.maps.LatLng(a,b);
					marker.setPosition(pos);
					if(cntr==12) {
						map.setCenter(pos);
						cntr=1;}
					else {
						cntr++;}	
					}
				setTimeout(follow2, 2000);
				}
			document.getElementById("aids").src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA90ZPwAZuHCBfyQRJYPUNwTm__vSc_dEg&callback=test";
		}
			
	</script>
	<script>
 
		function assign(id, i) {
			var x= $(id).val();
			if (x == "") {
				alert("Please select device to assign");}
			else {
			$.ajax({
				type: "GET",
				url: "send.php",
				data: {'a': x, 'b': i},
				success: function(data)
				{
					$("#test").html(data);
					$("#resp").css("display", "block");
				}
			});}
		}

		function ActiveDev() {
			$.get("dev.php", function(data) {
			$("#devices").html(data);
			window.setTimeout(ActiveDev, 2000);
			});
		}
		
		function cancel(i) {
			$.ajax({
				type: "GET",
				url: "cancel.php",
				data: {'a':"eh", 'b':i},
				success: function(data)
				{
					var ri = data.slice(data.length-1, data.length);
					if(ri == "e") {
						$("#test").html(data);
						$("#resp").css("display", "block");
						}
					else { 
						var str = data.slice(0, data.length-1);
						$("#resId").html(ri);
						$("#test").html(str);
						$("#resp").css("display", "block");
						$("#no").css("display", "block");
						$("#okay").html("Yes");
						}
				}
			});}
			
		function okay() {
			if ($("#okay").html() == "Yes") {
				var i=$("#resId").html();
				$("#resId").html()
				$.ajax({
				type: "GET",
				url: "cancel.php",
				data: {'a':"yes", 'b':i},
				success: function(data)
				{
					$("#test").html(data);
					$("#no").css("display", "none");
					$("#okay").html("Okay");
				}
			});
			}
			else {
				$("#resp").css("display", "none");}
		}	
		
		function no() {
			document.getElementById("test").innerHTML = "You pressed No. Rescue team assignment was not canceled.";
			document.getElementById("okay").innerHTML = "Okay";
			document.getElementById("no").style.display= "none";
		}
	</script>
	
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
	<p><strong>Active Devices</strong></p>
	</div>
	<div id="center">
	</div>
	<div id="respondent">
		<p><strong>Available Respondents</strong></p>
		<p>Santolan Volunteer 01</p>
		<select id="res1">
			<?php
				echo '<option value="">Select device</option>';
				include "option.php";
			?>
		</select></p>
		<button onclick="assign('#res1', 1)">Assign</button>
		<button onclick="cancel(1)">Cancel</button>
		<p>Santolan Rescue 02</p>
		<select id="res2">
			<?php
				echo '<option value="">Select device</option>';
				include "option.php";
			?>
		</select></p>
		<button onclick="assign('#res2', 2)">Assign</button>
		<button onclick="cancel(2)">Cancel</button>
	</div>
	<div id="resp">
	<p id="test"></p>
	<p id="resId" class="hidden"></p>
	<button id="okay" onclick="okay()">Okay</button><button id="no" onclick="no()" class="hidden">No</button>
	</div>
	<div class="footer">
	Copyright©2018 Life and Body Locator Box Thesis Group, All rights reserved.
	</div>
</body>
</html>
