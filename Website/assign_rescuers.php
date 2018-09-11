<?php
	include "conn.php";
	$q = "SELECT operator_id FROM operators WHERE operator_username='".$_SESSION['user']."'";
	$r = $conn->query($q);
	if($r->num_rows > 0) {
		while($rowa = $r->fetch_assoc()) {
			$operator_id = $rowa['operator_id'];
		}
	}
	$message = "";
	if(isset($_POST['assign'])) {
		if(!empty($_POST['respondents'])) {
			foreach($_POST['respondents'] as $selected){
				$query="SELECT * FROM rescuers WHERE rescuer_username='".$selected."'";
				$result = $conn->query($query);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$rescuer_name = $row['rescuer_name'];
						$queryB = "SELECT * FROM rescuers_location where rescuer_id=".$row['rescuer_id'];
						$resultB= $conn->query($queryB);
						if ($resultB->num_rows > 0) {
							while($rowB = $resultB->fetch_assoc()) {
								$rescuer_loc_id = $rowB['rescuer_loc_id'];
							}
						}
					}
				}
				$nquery = "SELECT rescuer_loc_id FROM rescue_operation WHERE device_loc_id=".$_POST['device']; 
				$nresult = $conn->query($nquery);
				if($nresult->num_rows > 0) {
					if($nresult->num_rows == 1) {
						while($nrow = $nresult->fetch_assoc()) {
							if($nrow['rescuer_loc_id'] == $rescuer_loc_id){
								$message = $message.'<p>'.$rescuer_name.' is already assigned to Device '.$_POST['device'].'</p>';

							}
							else if($nrow['rescuer_loc_id'] == NULL){
								$newquery= "UPDATE rescue_operation SET rescuer_loc_id=$rescuer_loc_id, rescuer_status='active' WHERE device_loc_id=".$_POST['device'];
								if ($conn->query($newquery) == true) {
									$message = $message.'<p>'.$rescuer_name.' is successfully assigned to Device '.$_POST['device'].'</p>';
								}
								else {
									$message = $message.'<p>'.$rescuer_name.' could not be assigned to Device '.$_POST['device'].'</p>';
								}
							}
							else{
								$queryC="SELECT operation_id FROM rescue_operation";
								$resultC= $conn->query($queryC);
								if($resultC->num_rows > 0) {
									$operation_id = $resultC->num_rows+1;
									
								}
								$newquery="INSERT INTO rescue_operation (`operation_id`,`operator_id`, `device_loc_id`, `device_status`, `rescuer_loc_id`, `rescuer_status`) VALUES ('".$operation_id."','".$operator_id."','".$_POST['device']."','active','".$rescuer_loc_id."','on-route')";
								if ($conn->query($newquery) ==  true){
									$message = $message.'<p>'.$rescuer_name.' successfully assigned to Device '.$_POST['device'].'</p>';
								}
								else {
									$message = $message.'<p>'.$rescuer_name.' could not be assigned to Device '.$_POST['device'].'</p>';
								}
							}
						}	
					}
					else {
						$checker = false;
						while($nrow = $nresult->fetch_assoc()) {
							if($nrow['rescuer_loc_id'] == $rescuer_loc_id){
								$checker = true;
							}
						}
						if($checker == true) {
							$message = $message.'<p>'.$rescuer_name.' is already assigned to Device '.$_POST['device'].'</p>';
						}
						else {
							$queryC="SELECT operation_id FROM rescue_operation";
							$resultC= $conn->query($queryC);
							if($resultC->num_rows > 0) {
								$operation_id = $resultC->num_rows+1;
								
							}
							$newquery="INSERT INTO rescue_operation (`operation_id`,`operator_id`, `device_loc_id`, `device_status`, `rescuer_loc_id`, `rescuer_status`) VALUES ('".$operation_id."','".$operator_id."','".$_POST['device']."','active','".$rescuer_loc_id."','on-route')";
							if ($conn->query($newquery) ==  true){
								$message = $message.'<p>'.$rescuer_name.' successfully assigned to Device '.$_POST['device'].'</p>';
							}
							else {
								$message = $message.'<p>'.$rescuer_name.' could not be assigned to Device '.$_POST['device'].'</p>';
							}
						}
					}
				}
			}
			echo '<div id="notification">'.$message.'<button onclick="close_notif()">Ok</button></div>';
		}
	}
?>