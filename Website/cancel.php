<?php
	include "conn.php";
	$a= $_GET["a"];
	$b = $_GET["b"];
	$s = 'UPDATE rescue_team SET rescue_team_status="Standby", rescue_team_current_task="none" WHERE id='.$b;
	$q = "SELECT rescue_team_status FROM rescue_team WHERE id=".$b;
	if ($a == "yes")
		{if ($conn->query($s) == true) {
			echo 'Rescue team assignment canceled';
			}
		else { echo 'Something went wrong. Please try again';
			}
		}
	else {
		$r = $conn->query($q);
		if ($r->num_rows > 0) 
			{while($row = $r->fetch_assoc()) 
				{if ($row["rescue_team_status"]=="On Route") {
					echo 'Would you like to cancel rescue team assignment?'.$b;
				}
				else { echo 'Rescue team not assigned to a device';
					}
				}
			}
	}
?>