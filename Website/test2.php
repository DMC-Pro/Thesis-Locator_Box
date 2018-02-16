<?php
	include "conn.php";
	$query = "SELECT device_status, device_id FROM devices";
	$result = $conn->query($query);
	if ($result->num_rows > 0) 
		{while($row = $result->fetch_assoc()) 
			{if ($row["device_status"]=="Active")
				{echo '<a href="#" onclick="send(this.innerHTML, 1)">'.$row["device_id"]."</a>";}
			} 
		}
	else {echo "0 results";}
?>