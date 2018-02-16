<!DOCTYPE html>
<html>
<body>
<?php
	include "conn.php";
		
	$a = $_GET["a"];
	$b = $_GET["b"];
	$s = 'UPDATE rescue_team SET rescue_team_status="On Route", rescue_team_current_task='.$a.' WHERE id='.$b;
	$q = "SELECT rescue_team_status, rescue_team_current_task FROM rescue_team WHERE id=".$b;
	$r = $conn->query($q);
		if ($r->num_rows > 0) 
			{while($row = $r->fetch_assoc()) 
				{if ($row["rescue_team_status"]=="On Route")
					{ if ($conn->query($s) == true) {
						echo '<p>Rescue task changed from '.$row["rescue_team_current_task"].' to '.$a.'</p>';
						}
					}
				else {
					if ($conn->query($s) == true) {
						echo "<p>Rescue team sent!</p>";
						}
					else { echo '<p>Something went wrong. Please try again</p>';
						}
					}
				}
			}
?>	
</body>
</html>		