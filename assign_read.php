<?php
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
    
    if ( null==$id ) {
        header("Location: assignments.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM assignments where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
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
                        <h3>Read an Assignment</h3>
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
                     
                     <div class="form-horizontal" >
                      <div class="control-group">
                        <label class="control-label">Customer:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo ($data['assign_per_id']);?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Event:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo ($data['assign_event_id']);?>
                            </label>
                        </div>
                      </div>
                        <div class="form-actions">
                          <a class="btn" href="assignments.php">Back</a>
                       </div>
                         </div>
                     
                 
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>