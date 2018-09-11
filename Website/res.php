<?php
	include "conn.php";
	if(isset($_POST['assign'])) {
		if(!empty($_POST['respondents'])) {
			foreach($_POST['respondents'] as $selected){
				echo $selected;
			}
		}
	}
	$a= $_GET["a"];
	$b = $_GET["b"];
	echo '<span class="close">&times;</span><p><strong>Available Rescuers</strong></p>';	
	$query = "SELECT * FROM rescuers INNER JOIN rescuers_location WHERE rescuers.rescuer_id=rescuers_location.rescuer_id";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		echo'<form method="post"><input type="text" class="hidden" name="device" value="'.$b.'" /></p>';
		while($row = $result->fetch_assoc()) {
			echo '<input type="checkbox" name="respondents[]" value='.$row['rescuer_username'].'>'.$row['rescuer_name'].'</p><p class="hidden">'.$row['rescuer_latitude'].'</p><p class="hidden">'.$row['rescuer_longitude'].'</p>';
		}
		echo '<input type="submit" name="assign" value="Assign"></form>
		<script>
		var exit = document.getElementsByClassName("close")[0];
		var rescuer_container = document.getElementById("rescuer");
		exit.onclick = function() {
		rescuer_container.style.display = "none";
		}
		</script>';
	}
?>