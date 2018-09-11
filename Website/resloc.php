<?php
	include "conn.php";
	$count=0;
	$query = "SELECT * FROM rescuers INNER JOIN rescuers_location WHERE rescuers.rescuer_id=rescuers_location.rescuer_id";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {	
			$resLatLng[$count] = array($row["rescuer_name"],$row["rescuer_latitude"],$row["rescuer_longitude"]);
			$count++;
		}
		echo json_encode($resLatLng);
	}
?>