<?php
	include "conn.php";
	echo "<p style='font-size:120%;text-align:center;'><strong>Available Respondents</strong></p>";
	$count=0;
	$query = "SELECT * FROM rescuers INNER JOIN rescuers_location WHERE rescuers.rescuer_id=rescuers_location.rescuer_id";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo '<table><tr>
					<td colspan="4" class="bb">'.$row["rescuer_name"].'<button onclick="newCenter('.$row["rescuer_latitude"].','.$row["rescuer_longitude"].')" class="dropbtn2" id="rescuer'.$count.'">Show on Map</button></td>
				</tr>
				<tr>
					<td class="aa">Lat:</td>
					<td>'.$row["rescuer_latitude"]."</td>
					<td class='aa'>Long:</td>
					<td>".$row["rescuer_longitude"]."</td>
				</tr>
				<tr>
					<td class='aa' colspan='4'>Assigned Devices:</td>
				</tr>";
			$newquery = "SELECT device_loc_id FROM rescue_operation WHERE rescuer_loc_id=".$row['rescuer_loc_id'];
			$newresult = $conn->query($newquery);
			if ($newresult->num_rows > 0) {
				while($nrow = $newresult->fetch_assoc()) {
					echo "<tr><td colspan='4'>Device".$nrow['device_loc_id']."</td></tr>";
				}
			}
			else {
				echo "<tr>
						<td style='text-align:center;' colspan='4'><i>No devices assigned</i></td>
					</tr>";
			}
			echo "</table>";
			$count++;
		}
		echo "<button class='dropbtn cc' onclick='add()'>Add Rescuer</button>";
	}
?>