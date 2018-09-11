<?php
	include "conn.php";
	$count=0;
	$query = "SELECT * FROM devices_location";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {	
			$q = "SELECT * FROM rescue_operation WHERE device_loc_id=".$row["device_loc_id"];
			$r = $conn->query($q);
			if ($r->num_rows > 0) {
				$devLatLng[$count] = array("Device ".$row["device_loc_id"],$row["device_latitude"],$row["device_longitude"]);
				$count++;
			}
		}
		echo json_encode($devLatLng);
	}
?>