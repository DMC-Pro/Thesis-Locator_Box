<?php
	include "conn.php";
	$query = "SELECT device_status, device_id FROM devices";
	$result = $conn->query($query);
	if ($result->num_rows > 0) 
		{while($row = $result->fetch_assoc()) 
			{if ($row["device_status"]=="Active")
				{echo '<option value="'.$row["device_id"].'">'.$row["device_id"]."</option>";}
			} 
		}
	else {echo "no active devices";}
?>