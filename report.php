<?php
	session_start();
    $has_Session_DisplayName = isset($_SESSION["SESS_DISPLAYNAME"]);
				if($has_Session_DisplayName == false) {
                     header('Location: login.php');
				}
	require_once "db.php";
	$conn = new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
	$sql = "SELECT * FROM incident_type";
	$result = $conn->query($sql);
	$incidentTypes = [];
	while($row = $result->fetch_assoc()){
		$id = $row["incident_type_id"];
		$type = $row["incident_type_desc"];
		$incidentType = ["id"=>$id, "type"=>$type];
		array_push($incidentTypes, $incidentType);
	}
	$query = 'SELECT incident.incident_id, incident.caller_name, incident.phone_number, incident.incident_type_id, incident.incident_location, incident.incident_desc, incident.incident_status_id,  incident.time_called, dispatch.incident_id, dispatch.time_arrived, dispatch.time_completed 
	from dispatch
	INNER JOIN incident 
	ON dispatch.incident_id = incident.incident_id';
	$noFilter = @mysqli_query($conn, $query);	
?>
	
<title>Reports</title>
<link href="css/bootstrap-4.4.1.css" rel="stylesheet" type="text/css">
<body>
<div class="container" style="width:900px">
	<?php
		include "header.php";
	?>
	<form method="POST" class="mt-3 text-center">
		<input type="date" name="start">
		<input type="date" name="end">
		<button type="submit" class="btn btn-primary" name="filterBtnClicked"'>Filter</button>
	</form>
		<table class="table table-striped">
			<?php 
			echo '<tr>
			  <th scope="col">Incident ID</th>
			  <th scope="col">Caller Name</th>
			  <th scope="col">Phone Number</th>
			  <th scope="col">Incident Type</th>
			  <th scope="col">Incident Location</th>
			  <th scope="col">Incident Description</th>
			  <th scope="col">Incident Status</th>
			  <th scope="col">Time Called</th>
			  <th scope="col">Time Arrived</th>
			  <th scope="col">Time Completed</th>
			</tr>';
					
				if (isset($_POST["filterBtnClicked"])){
					$startDate = $_POST["start"];
					$endDate = $_POST["end"];
					$query = "SELECT incident.incident_id, incident.caller_name, incident.phone_number, incident.incident_type_id, incident.incident_location, incident.incident_desc, incident.incident_status_id,  incident.time_called, dispatch.incident_id, dispatch.time_arrived, dispatch.time_completed 
					from dispatch
					INNER JOIN incident 
					ON dispatch.incident_id = incident.incident_id
					WHERE time_called BETWEEN '$startDate' and '$endDate'";
					$filtered = @mysqli_query($conn, $query);
					@mysqli_query($conn, $query);
					
				  	while($row = mysqli_fetch_array($filtered)){
					echo '<tr><td>' .
					$row['incident_id'] . '</td><td>' .
					$row['caller_name'] . '</td><td>' .
					$row['phone_number'] . '</td><td>' .
					$row['incident_type_id'] . '</td><td>' .
					$row['incident_location'] . '</td><td>' .
					$row['incident_desc'] . '</td><td>' .
					$row['incident_status_id'] . '</td><td>' .
					$row['time_called'] . '</td><td>' .
					$row['time_arrived'] . '</td><td>' .
					$row['time_completed'] . '</td><td>';
				echo '</tr>';}
				} 
				else {
				while($row = mysqli_fetch_array($noFilter)){
				echo '<tr><td>' .
					$row['incident_id'] . '</td><td>' .
					$row['caller_name'] . '</td><td>' .
					$row['phone_number'] . '</td><td>' .
					$row['incident_type_id'] . '</td><td>' .
					$row['incident_location'] . '</td><td>' .
					$row['incident_desc'] . '</td><td>' .
					$row['incident_status_id'] . '</td><td>' .
					$row['time_called'] . '</td><td>' .
					$row['time_arrived'] . '</td><td>' .
					$row['time_completed'] . '</td><td>';
				echo '</tr>';}
				}
				?>
		</table>
	<?php
		include "footer.php";
	?>
</div>
<script src="js/jquery-3.4.1.min.js"></script> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap-4.4.1.js"></script>
</body>