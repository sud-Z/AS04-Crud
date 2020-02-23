<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: assignments.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$customerError = null;
		$eventError = null;
		
		// keep track post values
	    $customerId = $_POST['customerId'];
		$eventId = $_POST['eventId'];
		
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
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE assignments  set assign_per_id = ?, assign_event_id = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($customerId,$eventId));
			Database::disconnect();
			header("Location: assignments.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM assignments where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$customerId = $data['assign_per_id'];
		$eventId = $data['assign_event_id'];
		Database::disconnect();
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
		    			<h3>Update an Assignment</h3>
		    		</div>
		    		
		    		 <div class="row">
                        <h4>Customers</h4>
                    </div>
		    		
		    			<table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email Address</th>
                          <th>Mobile Number</th>
                          <th>ID</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       
                       $pdo = Database::connect();
                       $sql = 'SELECT * FROM customers ORDER BY id DESC';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['name'] . '</td>';
                                echo '<td>'. $row['email'] . '</td>';
                                echo '<td>'. $row['mobile'] . '</td>';
                                echo '<td>'. $row['id'] . '</td>';
                                echo '</tr>';
                       }
                       Database::disconnect();
                      ?>
                      </tbody>
                </table>
                
                 <div class="row">
                        <h4>Events</h4>
                    </div>
                    
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Location</th>
                          <th>Descritpion</th>
                          <th>ID</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       $pdo = Database::connect();
                       $sql = 'SELECT * FROM events ORDER BY id DESC';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['event_date'] . '</td>';
                                echo '<td>'. $row['event_time'] . '</td>';
                                echo '<td>'. $row['event_location'] . '</td>';
                                echo '<td>'. $row['event_description'] . '</td>';
                                echo '<td>'. $row['id'] . '</td>';
                                echo '</tr>';
                       }
                       Database::disconnect();
                      ?>
                      </tbody>
                </table>
    		
	    			<form class="form-horizontal" action="assign_update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($customerError)?'error':'';?>">
					    <label class="control-label">Customer ID</label>
					    <div class="controls">
					      	<input name="customerId" type="text"  placeholder="Customer ID" value="<?php echo !empty($customerId)?$customerId:'';?>">
					      	<?php if (!empty($customerError)): ?>
					      		<span class="help-inline"><?php echo $customerError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($eventError)?'error':'';?>">
					    <label class="control-label">Event ID</label>
					    <div class="controls">
					      	<input name="eventId" type="text" placeholder="Event ID" value="<?php echo !empty($eventId)?$eventId:'';?>">
					      	<?php if (!empty($eventError)): ?>
					      		<span class="help-inline"><?php echo $eventError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="assignments.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>