<?php
	include "conn.php";
	$message="";
	if(isset($_POST['addrescuer'])) {
		$queryA="SELECT rescuer_id FROM rescuers";
		$resultA= $conn->query($queryA);
		if($resultA == false){
			$message = $message."Something went wrong1";
		}
		else if($resultA->num_rows > 0) {
			$rescuer_id = $resultA->num_rows+1;
			$password = password_hash("'".$_POST["rescuer_password"]."'", PASSWORD_BCRYPT);
			$query = "INSERT INTO rescuers(`rescuer_id`, `rescuer_name`, `rescuer_type`, `rescuer_username`, `rescuer_password`) VALUES (".$rescuer_id.",'".$_POST["rescuer_name"]."','".$_POST["rescuer_type"]."','".$_POST["rescuer_username"]."','".$password."')";
			$result = $conn->query($query);
			if($result == true){
				$queryC = "INSERT INTO rescuers_location(`rescuer_loc_id`, `rescuer_latitude`, `rescuer_longitude`, `rescuer_altitude`, `rescuer_id`) VALUES (".$rescuer_id.",".$_POST["rescuer_lat"].",".$_POST["rescuer_lng"].",'0',".$rescuer_id.")";
				$resultC = $conn->query($queryC);
				if($resultC == true){
					$message = $message."Rescuer successfully added";
				}
				else {
					$message = $message."Something went wrong3";
				}
			}
			else {
				$message = $message."Something went wrong2";
			}
		}
		echo '<div id="notification"><p>'.$message.'</p><button onclick="close_notif()">Ok</button></div>';
	}
	else if(isset($_POST['cancel'])) {

	}
?>