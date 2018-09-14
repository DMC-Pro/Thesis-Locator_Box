<!DOCTYPE html>
<html>
<head>
	<?php
		include "session.php";
		include "assign_rescuers.php";
	?>
	<link rel="stylesheet" type="text/css" href="res/style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA90ZPwAZuHCBfyQRJYPUNwTm__vSc_dEg&callback=cLoc">
    </script>
	<script>
		var map
		var markers = [];
		function cLoc() {
			map = new google.maps.Map(document.getElementById('center'), {
				zoom: 18,
				center: new google.maps.LatLng(14.5979292, 121.01075560000004),
				mapTypeId: google.maps.MapTypeId.ROADMAP
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
			    		var marker, i, j;
			    		for (i = 0; i < reslocations.length; i++) {
								marker = new google.maps.Marker({
				        		position: new google.maps.LatLng(reslocations[i][1], reslocations[i][2]),
				        		map: map,
				        		icon: resIcon
				      			});
							markers.push(marker);	
			      			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				        		return function() {
				          			infowindow.setContent(reslocations[i][0]);
				          			infowindow.open(map, marker);
				        			}
				      			})(marker, i));
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

		function ActiveDev() {
			$.get("dev.php", function(data) {
			$("#devices").html(data);
			window.setTimeout(ActiveDev, 2000);
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
	</script>

</head>

<body onload="ActiveDev()">

	<div class="topnav">
		<img src="res/logo.png" id="logo" height="45px" width="45px">
	    <a href="/thesis/">Home</a>
	    <a href="rescuers.php">Rescuers</a>
	</div>

	<div id="devices">

	</div>

	<div id="center">

	</div>

	<div id="rescuer">
		
	</div>

	<div class="footer">
	Copyright©2018 Life and Body Locator Box Thesis Group, All rights reserved.
	</div>

</body>
</html>