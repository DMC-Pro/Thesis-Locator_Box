<?php
	include "conn.php";
	$count=0;
	$array = ""
	$query = "SELECT * FROM devices_location";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {	
			$q = "SELECT * FROM rescue_operation WHERE device_loc_id=".$row["device_loc_id"];
			$r = $conn->query($q);
			if ($r->num_rows > 0) {
				$array[$row['device_loc_id']]['info']='<b> Device'.$row['device_loc_id'].'</b>';
				$array[$row['device_loc_id']]['lat']=$row['device_latitude'];
				$array[$row['device_loc_id']]['lng']=$row['device_longitude'];
			}
		}
		echo json_encode($array);
	}
?>