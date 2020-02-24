<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$customerError = null;
		$eventError = null;
		
		// keep track post values
		$customerId = $_POST['customer_Id'];
		$eventId = $_POST['event_Id'];
		
		// validate input
		$valid = true;
		if (empty($customerId)) {
			$customerError = 'Please Choose a Customer';
			$valid = false;
		}
		
		if (empty($eventId)) {
			$eventError = 'Please Choose an Event';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO assignments (assign_per_id,assign_event_id) values(?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($customerId,$eventId));
			Database::disconnect();
			header("Location: assignments.php");
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    		
		<div class="span10 offset1">
			<div class="row">
				<h3>Assign a Volunteer to an Event</h3>
			</div>
	
			<form class="form-horizontal" action="assign_create.php" method="post">
		
				<div class="control-group">
					<label class="control-label">Customer</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM customers ORDER BY name ASC';
							echo "<select class='form-control' name='customer_Id' id='customer_Id'>";
							
							foreach ($pdo->query($sql) as $row) {
									echo "<option value='" . $row['id'] . " '> " . $row['name'] . ', ' .$row['mobile'] . "</option>";
							}
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->
				
				<div class="control-group">
					<label class="control-label">Event</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM events ORDER BY event_date ASC, event_time ASC';
							echo "<select class='form-control' name='event_Id' id='event_Id'>";
								foreach ($pdo->query($sql) as $row) {
									echo "<option value='" . $row['id'] . " '> " . $row['event_description'] . " (" . $row['event_time'] . ") - " .
									trim($row['event_date']) . " - " .
									trim($row['event_location']) .
									"</option>";
								}
								
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->
			  
				
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Confirm</button>
						<a class="btn" href="fr_assignments.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
    		
    		
				
    </div> <!-- /container -->
  </body>
</html>
