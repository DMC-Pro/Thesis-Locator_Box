<?php
		include "conn.php";
			
		$query = "SELECT rescuer_latitude, rescuer_longitude FROM rescue_team";
		$result = $conn->query($query);
		if ($result->num_rows > 0) 
			{for($count = 1; $row = $result->fetch_assoc();$count++) 
				echo '<p class="hidden" id="rlat'.$count.'">'.$row["rescuer_latitude"].'</p>
				<p class="hidden" id="rlng'.$count.'">'.$row["rescuer_longitude"].'</p>';
			}
?>