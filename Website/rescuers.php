<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="res/style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script id="aids" async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA90ZPwAZuHCBfyQRJYPUNwTm__vSc_dEg&callback=cLoc">
    </script>
	<script>
	
		function cLoc(x) {
			var map = new google.maps.Map(document.getElementById('center'), {
				zoom: 18,
				center: new google.maps.LatLng(14.5979292, 121.01075560000004),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			var initial = new google.maps.Marker({
				position: new google.maps.LatLng(14.5979292, 121.01075560000004),
				map: map
			});
			var devMarker = new google.maps.Marker({
				position: new google.maps.LatLng(14.6221, 121.0860),
				map: map
				});
			
			var y = document.getElementById("dev1");
			if (x == 1) {
				var a= document.getElementById('lat1').innerHTML;
				var b= document.getElementById('lng1').innerHTML;
				var uluru = new google.maps.LatLng(a,b);
				map.setCenter(uluru);
				var cntr1= 1;
				function follow1() {
					a= document.getElementById('lat1').innerHTML;
					b= document.getElementById('lng1').innerHTML;
					var pos = new google.maps.LatLng(a,b);
					devMarker.setPosition(pos);
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
				map.setCenter(uluru);
				var cntr=1;
				function follow2() {
					var a= document.getElementById('lat2').innerHTML;
					var b= document.getElementById('lng2').innerHTML;
					var pos = new google.maps.LatLng(a,b);
					devMarker.setPosition(pos);
					if(cntr==12) {
						map.setCenter(pos);
						cntr=1;}
					else {
						cntr++;}	
					}
				setInterval(follow2, 2000);
				}
				
			var ResLat1= document.getElementById('rlat1').innerHTML;
			var ResLng1= document.getElementById('rlng1').innerHTML;
			var ResLocOne = new google.maps.LatLng(ResLat1,ResLng1);
			var resMarker= new google.maps.Marker({
				position: ResLocOne,
				icon: "res/blue1.png", 
				map: map
			});
			var re1 = document.getElementById("re1");

			function followRescuer() {
				ResLat1= document.getElementById('rlat1').innerHTML;
				ResLng1= document.getElementById('rlng1').innerHTML;
				var newpos = new google.maps.LatLng(ResLat1,ResLng1);
				resMarker.setPosition(newpos);
				}
			setInterval(followRescuer, 2000);
			
			var ResLat2 = document.getElementById('rlat2').innerHTML;
			var ResLng2 = document.getElementById('rlng2').innerHTML;
			var ResLocTwo = new google.maps.LatLng(ResLat2,ResLng2);
			var restwomarker = new google.maps.Marker({
				position: ResLocTwo,
				icon: "res/blue1.png",
				map: map
			});
			
			function ResTwoFollow() {
				ResLat2= document.getElementById('rlat2').innerHTML;
				ResLng2= document.getElementById('rlng2').innerHTML;
				var NewResLocTwo = new google.maps.LatLng(ResLat2,ResLng2);
				restwomarker.setPosition(NewResLocTwo);	
			}
			setInterval(ResTwoFollow, 2000);
			
		}
		
		function close_notif() {
			var container =  document.getElementById('notification');
			container.style.display = "none";
		}

	</script>
	<script>
	
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
			
	</script>
	<?php
		include "conn.php";
		if(isset($_POST['assign'])) {
			if(!empty($_POST['rescuers'])) {
				foreach($_POST['rescuers'] as $selected){
					$query="SELECT rescuer_loc_id FROM rescuers WHERE rescuer_name='".$selected."'";
					$result = $conn->query($query);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							$rescuer_loc_id = $row['rescuer_loc_id'];
						}
					}
					$nquery = "SELECT rescuer_loc_id FROM rescue_operation WHERE device_loc_id=".$_POST['device'];
					$nresult = $conn->query($nquery);
					if($nresult->num_rows > 0) {
						while($row = $nresult->fetch_assoc()) {
							if($row['rescuer_loc_id'] == NULL) {
								$newquery= "UPDATE rescue_operation SET rescuer_loc_id=$rescuer_loc_id, rescuer_status='active' WHERE device_loc_id=".$_POST['device'];
								if ($conn->query($newquery) == true) {
									echo '<script> var notification = document.getElementById("notification");
										var message = document.getElementById("message");
										message.innerHTML = "'.$selected.' is assigned to Device'.$_POST['device'].'";
										notification.style.display = "block";
									</script>';
								}
								else {
									echo '<script> var notification = document.getElementById("notification");
										var message = document.getElementById("message");
										message.innerHTML = "Something went wrong. Please try again.";
										notification.style.display = "block";
									</script>';
								}
							}
							else if($row['rescuer_loc_id'] == $rescuer_loc_id) {
								echo '<script> var notification = document.getElementById("notification");
										var message = document.getElementById("message");
										message.innerHTML = "'.$selected.' is already assigned to Device'.$_POST['device'].'";
										notification.style.display = "block";
									</script>';
							}
							else {
								$newquery="INSERT INTO rescue_operation('operator_id', 'device_loc_id', 'device_status', 'rescuer_loc_id', 'rescuer_status') VALUES ('','".$_POST['device']."','active','".$rescuer_loc_id."','on route')";
								if ($conn->query($newquery) ==  true){
									echo '<script> var notification = document.getElementById("notification");
										var message = document.getElementById("message");
										message.innerHTML = "'.$selected.' is assigned to Device'.$_POST['device'].'";
										notification.style.display = "block";
									</script>';
								}
								else {
									echo '<script> var notification = document.getElementById("notification");
										var message = document.getElementById("message");
										message.innerHTML = "Something went wrong. Please try again.";
										notification.style.display = "block";
									</script>';
								}
							}
						}
					}
				}
			}
		}
	?>
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
	
	<div class="footer">
	Copyright©2018 Life and Body Locator Box Thesis Group, All rights reserved.
	</div>
</body>
</html>