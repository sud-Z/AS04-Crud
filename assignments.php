<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>Assignments</h3>
            </div>
            <div class="row">
                <p>
                    <a href="assign_create.php" class="btn btn-success">Create</a>
                </p>
                 
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Event Date</th>
                          <th>Event Time</th>
                          <th>Event Location</th>
                          <th>Customer Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       include 'database.php';
                       $pdo = Database::connect();
                       $sql = 'SELECT * FROM assignments 
						LEFT JOIN customers ON customers.id = assignments.assign_per_id 
						LEFT JOIN events ON events.id = assignments.assign_event_id
						ORDER BY event_date ASC, event_time ASC, name ASC;';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['event_date'] . '</td>';
                                echo '<td>'. $row['event_time'] . '</td>';
                                echo '<td>'. $row['event_location'] . '</td>';
                                echo '<td>'. $row['name'] . '</td>';
                                echo '<td width=250>';
                                echo '<a class="btn" href="assign_read.php?id='.$row[0].'">Read</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="assign_update.php?id='.$row[0].'">Update</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="assign_delete.php?id='.$row[0].'">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                       }
                       Database::disconnect();
                      ?>
                      </tbody>
                </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>