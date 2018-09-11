<?php
	include "conn.php";
	echo "<p style='font-size:120%;text-align:center;'><strong>Active Devices</strong></p>";
	$count = 0;
	$query = "SELECT * FROM devices_location";
	$result = $conn->query($query);
	if($result == false){
	 	echo "<tr>
			<td style='text-align:center;' colspan='4'><i>No devicesd</i></td>
		</tr>";
	}
	else if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {	
			$devLatLng[$count] = array("Device".$row["device_loc_id"],$row["device_latitude"],$row["device_longitude"]);		
			$q = "SELECT * FROM rescue_operation WHERE device_loc_id=".$row["device_loc_id"];
			$r = $conn->query($q);
			if($r == false){
				echo "<tr>
						<td style='text-align:center;' colspan='4'><i>Device not active.</i></td>
					</tr>";
			}
			else if ($r->num_rows > 0) {
				echo '<table>
						<tr>
							<td colspan="4" class="bb">Device '.$row["device_loc_id"].'<button onclick="cLoc()" class="dropbtn2" id="dev'.$count.'">Show on Map</button></td>
						</tr>
						<tr>
							<td class="aa">Lat:</td>
							<td>'.$row["device_latitude"]."</td>
							<td class='aa'>Long:</td>
							<td>".$row["device_longitude"]."</td>
						</tr>
						<tr>
							<td class='aa' colspan='4'>Assigned Rescuers:</td>
						</tr>";
				while($rowb = $r->fetch_assoc()) {	
					$a = "SELECT rescuer_id FROM rescuers_location WHERE rescuer_loc_id=".$rowb["rescuer_loc_id"];
					$b = $conn->query($a);
					if($b == false)
					{
					 echo "<tr>
							<td style='text-align:center;' colspan='4'><i>No rescuers assigned</i></td>
						</tr>";
					}
					else if ($b->num_rows > 0) {
						while($rowc = $b->fetch_assoc()) {
							$c = "SELECT rescuer_name, rescuer_type FROM rescuers WHERE rescuer_id=".$rowc["rescuer_id"];
							$d = $conn->query($c);
							if ($d->num_rows > 0) {
								while($rowd = $d->fetch_assoc()) {
									echo "<tr>
											<td style='text-align:center;' colspan='4'>".$rowd["rescuer_name"]."(".$rowd["rescuer_type"].")</td>
										</tr>";
								}
							}
						}
						
					}
				}
				echo '<tr><td colspan="4"><button class="dropbtn" onclick="rescuers('.$row['device_loc_id'].')">Assign Rescuers</button></td></tr></table>';
				$count++;
			}
		}
		echo "<p class='hidden'>".$count."</p>";
	} 
?>
