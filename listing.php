<?php
include("_header.php");
include("db_init.php");
include("crud_tools.php");

//TODO ADD PASSENGER VIEW FOR SEEING WHOS IN THE CARPOOL
//TODO ADD/FINISH Carpool applicant approval view for admin
?>

<div id=listing_info>

  <?php
  if (isset($_GET["id"])) {
    $id = $_GET["id"];//$_POST["recommend"]
  } else {
    echo 'ERROR! User id field is unset.';
    $id = 1;
  }

  if ($results_users = $mysqli->prepare("select carpool_id, carpool_creator, leave_date , created_date, from_lat , from_long , destination_lat, destination_long, details, open_to_passengers FROM rides WHERE carpool_id = ?")) {

    $results_users->bind_param("i", $id);
  	$results_users->execute();

    $obj = $results_users->get_result()->fetch_object();
    if(!($obj)){
      echo 'ERROR! NO SQL RESULT OBJECT';
    }

    $carpool_id         = $obj->carpool_id;
    $carpool_creator    = $obj->carpool_creator;
    $leave_date         = $obj->leave_date;
    $created_date       = $obj->created_date;
    $from_lat           = $obj->from_lat;
    $from_long          = $obj->from_long;
    $destination_lat    = $obj->destination_lat;
    $destination_long   = $obj->destination_long;
    $details            = $obj->details;
    $open_to_passengers = $obj->open_to_passengers;

    crud_dispdiv_create('carpool_id','ID',$carpool_id);
    crud_dispdiv_create('carpool_creator','Creator',$carpool_creator);
    crud_dispdiv_create('carpool_leave_date','Leave Date',$leave_date);
    crud_dispdiv_create('carpool_created_date','Created Date',$created_date);
    crud_dispdiv_create('carpool_from_lat','From Latitude',$from_lat);
    crud_dispdiv_create('carpool_from_long','From Longitude',$from_long);
    crud_dispdiv_create('carpool_destination_lat','Destination Latitude',$destination_lat);
    crud_dispdiv_create('carpool_destination_long','Destination Longitude',$destination_long);
    crud_dispdiv_create('carpool_details','Details',$details);
    crud_dispdiv_create('carpool_open_to_passengers','Open To Passengers',$open_to_passengers);

    $results_users->close();

  } else {
    echo 'SQL Prepare failed.';
  }
  ?>

</div>

<?php
  //TODO implement session user_id usage
  if($uid === 1){//NON ADMIN CASE
 ?>
<div id=listing_app>
  <form method="post" action='apply.php' class="inform">
  <ul>
  <li><label>Application Description:<br></label> <textarea name="description" rows="4" cols="50" onKeyDown="charLimit(this.form.description, this.form.countdown, 1000);"
  	onKeyUp="charLimit(this.form.description, this.form.countdown, 1000);" placeholder="Enter application description."></textarea>
  <br><input readonly type="text" name="countdown" value="1000"> characters left
  <li><input type=submit name="Submit application">
  </ul>
  </form>
</div>

<?php
  echo '1';
}else{ //ADMIN CASE ?>

<div id=listing_app>
  <ol>
  <li><div id=applications></div></li>
    <?php

    //`app_id`, `ride_id_fk`, `applicant_uid_fk`, `decision_status`, `description`
    //convert to li factory
    echo "<table class='Applications'><tr><th>Driver or Passewnger<th>Score<th>Recommend?<th>Description<th></tr>";
    if ($apps_stmt = $mysqli->prepare("SELECT * FROM `carpool_applications` WHERE decision_status = 'PENDING'")) {
        $apps_stmt->bind_param("i", $id);
        $apps_stmt->execute();
        $app_rows = $apps_stmt->get_result();
        while($obj = $app_rows->fetch_object()){
                echo "<tr>";
                echo "<td>".htmlspecialchars($obj->driver_enum)."</td>";
                echo "<td>".htmlspecialchars($obj->score)."</td>";
                echo "<td>".htmlspecialchars($obj->recommend)."</td>";
                echo "<td>".htmlspecialchars($obj->description)."</td>";
                echo "</tr>";
        }

        $apps_stmt->close();
    }
    echo "</table>";
    ?>
  </ol>
</div>

<?php } ?>


<?php
mysqli_close($mysqli);
include("_footer.php");
?>
