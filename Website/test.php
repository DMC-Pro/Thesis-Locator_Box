<?php
	include "conn.php";
	echo "<p><strong>Active Devices</strong></p>";
	$count = 1;
	$query = "SELECT device_status, device_id, device_latitude, device_longitude FROM devices";
	$result = $conn->query($query);
	if ($result->num_rows > 0) 
		{while($row = $result->fetch_assoc()) 
			{if ($row["device_status"]=="Active")
				{echo '<button class="dropbtn" id="dev'.$count.'">'.$row["device_id"]."</button>"."</p>";
				echo '<p class="hidden" id="lat'.$count.'">'.$row["device_latitude"].'</p>';
				echo '<p class="hidden" id="lng'.$count.'">'.$row["device_longitude"].'</p>';
				$count=$count+1;}}} 
	else {echo "0 results";}
?>
