<!DOCTYPE html>
<html>
<head>
	<?php
		include "session.php";
		include "add_rescuers.php";
	?>
	<link rel="stylesheet" type="text/css" href="res/style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA90ZPwAZuHCBfyQRJYPUNwTm__vSc_dEg&callback=cLoc">
    </script>
	<script>
		var map
		var markers = [];
		var markerC = "";
		function cLoc() {
			map = new google.maps.Map(document.getElementById('center'), {
				zoom: 18,
				center: new google.maps.LatLng(14.5979292, 121.01075560000004),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});

			mapB = new google.maps.Map(document.getElementById('mapB'), {
				zoom: 18,
				center: new google.maps.LatLng(14.5979292, 121.01075560000004),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});

			mapB.addListener('click', function(event) {
		    	if(markerC == ""){
					markerC = new google.maps.Marker({
		          	position: event.latLng,
		          	map: mapB
		        	});
				}
		        else {
		        	markerC.setPosition(event.latLng);
		        }
		        var reslat = document.getElementById('lat');
		        var reslng = document.getElementById('long');
		        reslat.value = event.latLng.lat();
		        reslng.value = event.latLng.lng();
		    });

			function DevLoc(){
				$.ajax({
					type: "GET",
					url: "devloc.php",
					dataType: 'json',
					success: function(data){
						var devlocations = data;
						var infowindow = new google.maps.InfoWindow();
			    		var marker, i;
			    		for (i = 0; i < devlocations.length; i++) {  
			     			marker = new google.maps.Marker({
			        		position: new google.maps.LatLng(devlocations[i][1], devlocations[i][2]),
			        		map: map
			      			});
			     			markers.push(marker);
			      			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				        		return function() {
				          			infowindow.setContent(devlocations[i][0]);
				          			infowindow.open(map, marker);
				        			}
				      			})(marker, i));
			      		}
					}
				});
			}setInterval(DevLoc, 5000);

			var resIcon = "res/blue1.png";

			function ResLoc() {
				$.ajax({
					type: "GET",
					url: "resloc.php",
					dataType: 'json',
					success: function(data)
					{
						var reslocations = data;
						var infowindow = new google.maps.InfoWindow();
			    		var marker, markerB, i;
			    		for (i = 0; i < reslocations.length; i++) {
							marker = new google.maps.Marker({
			        		position: new google.maps.LatLng(reslocations[i][1], reslocations[i][2]),
			        		map: map,
			        		icon: resIcon
			      			});
							markers.push(marker);

							markerB = new google.maps.Marker({
			        		position: new google.maps.LatLng(reslocations[i][1], reslocations[i][2]),
			        		map: mapB,
			        		icon: resIcon
			      			});

			      			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				        		return function() {
				          			infowindow.setContent(reslocations[i][0]);
				          			infowindow.open(map, marker);
				        			}
				      			})(marker, i));

			      			google.maps.event.addListener(markerB, 'click', (function(markerB, i) {
				        		return function() {
				          			infowindow.setContent(reslocations[i][0]);
				          			infowindow.open(mapB, markerB);
				        			}
				      			})(markerB, i));
			      		}
					}
				});
			}
			setInterval(ResLoc, 5000);

			function setMapOnAll(map) {
		        for (var i = 0; i < markers.length; i++) {
		          markers[i].setMap(map);
		        }
	      	}

			function clearMarkers() {
		        setMapOnAll(null);
		        markers=[];
		    }setInterval(clearMarkers, 5000);

		}

		function newCenter(latitude,longitude){
			map.setCenter({
				lat : latitude,
				lng : longitude
			});
		}
		
		function close_notif() {
			var container =  document.getElementById('notification');
			container.style.display = "none";
		}

		function Rescuers() {
			$.get("rescuer.php", function(data) {
			$("#respondents").html(data);
			window.setTimeout(Rescuers, 2000);
			});
		}

		function feeder() {
			$.get("tester.php", function(data) {
			$("#test").html(data);
			window.setTimeout(feeder, 5000);
			});
		}

		function rescuers(aa){
			$.ajax({
				type: "GET",
				url: "res.php",
				data: {'a':"e", 'b':aa},
				success: function(data)
				{
					$('#rescuer').html(data);
					$("#rescuer").css("display", "block");
				}
			});
		}

		
		function add() {
			var modal = document.getElementById("modalcontainer");
			modal.style.display = "block";
		}

	</script>	
</head>
<body onload="Rescuers()">
	<div class="topnav">
		<img src="res/logo.png" id="logo" height="45px" width="45px">
	    <a href="/thesis/">Home</a>
	    <a href="rescuers.php">Rescuers</a>
	</div>
	<div id="respondents">

	</div>
	<div id="center">
	</div>
	<div id="rescuer">
		
	</div>

	<div id="modalcontainer">
		<div id ="modal">
			<span class="close">&times;</span>
			<div class="sideA">
				<form method="post">
					<strong>Rescuer Name: </strong><br>
					<input type="text" name="rescuer_name" /></p>
					<strong>Username: </strong><br>
					<input type="text" name="rescuer_username" /></p>
					<strong>Password: </strong><br>
					<input type="password" name="rescuer_password" /></p>
					<strong>Rescuer type: </strong><br>
					<input type="text" name="rescuer_type" /></p>
					<strong>Rescuer Latitude: </strong><br>
					<input type="text" id="lat" name="rescuer_lat" /></p>
					<strong>Rescuer Longitude: </strong><br>
					<input type="text" id="long" name="rescuer_lng" /></p>
					<p style="font-size: 11px;"><strong>NOTE: </strong>Click on map to set rescuer's latitude and longitude.</p>
					<center><input type="submit" name="addrescuer" value="Add" /><input type="submit" name="cancel" value="Cancel" /></center>
				</form>
			</div>
			<div id="mapB" class="sideB">

			</div>
			
		</div>
	</div>

	<script>
		var exit = document.getElementsByClassName("close")[0];
		exit.onclick = function() {
			var modal = document.getElementById("modalcontainer");
			modal.style.display = "none";
		}
	</script>
	
	<div class="footer">
	Copyright©2018 Life and Body Locator Box Thesis Group, All rights reserved.
	</div>
</body>
</html>