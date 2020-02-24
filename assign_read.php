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
        # get assignment details
        $sql = "SELECT * FROM assignments where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);

        # get volunteer details
        $sql = "SELECT * FROM customers where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($data['assign_per_id']));
        $perdata = $q->fetch(PDO::FETCH_ASSOC);

        # get event details
        $sql = "SELECT * FROM events where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($data['assign_event_id']));
        $eventdata = $q->fetch(PDO::FETCH_ASSOC);
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
                    
                
                
                     
                     <div class="form-horizontal" >
                      <div class="control-group">
                        <label class="control-label">Customer:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo ($perdata['name']);?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Event Location:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo ($eventdata['event_location']);?>
                            </label>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Event Date:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo ($eventdata['event_date']);?>
                            </label>
                        </div>
                      </div>
                       <div class="control-group">
                        <label class="control-label">Event Description:</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo ($eventdata['event_description']);?>
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
