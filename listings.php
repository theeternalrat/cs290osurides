<?php
include("_header.php");
include("db_init.php");
?>

<div id=rides>
  <?php
  echo "<table class='rides'><tr><th>Carpool Id<th>Leave Date<th>From Latitude<th>From Longitude<th>Destination Latitude<th>Destination Longitude<th></tr>";
  if ($result_rides_stmt = $mysqli->prepare("SELECT `carpool_id`, `leave_date`, `from_lat`, `from_long`, `destination_lat`, `destination_long`, `details`, FROM `rides` WHERE open_to_passengers = TRUE")) {
      $result_rides_stmt->execute();
      $result_rides = $result_rides_stmt->get_result();
      while($obj = $result_rides->fetch_object()){
              echo "<tr>";
              echo "<td>".htmlspecialchars($obj->carpool_id)."</td>";
              echo "<td>".htmlspecialchars($obj->leave_date)."</td>";
              echo "<td>".htmlspecialchars($obj->from_lat)."</td>";
              echo "<td>".htmlspecialchars($obj->from_long)."</td>";
              echo "<td>".htmlspecialchars($obj->destination_lat)."</td>";
              echo "<td>".htmlspecialchars($obj->destination_long)."</td>";
			  echo "<td>".htmlspecialchars($obj->details)."</td>";
              echo "</tr>";
      }
      $result_rides_stmt->close();
  }else{
    echo "SQL Prepare failed.;
  }
  echo "</table>";
  ?>
</div>

<?php
mysqli_close($mysqli);
include("_footer.php");
?>
