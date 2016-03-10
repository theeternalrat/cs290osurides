<?php
include("_header.php");

if(checkAuth(true) != ""){

include("db_init.php");
include("crud_tools.php");

//TODO ADD PASSENGER VIEW FOR SEEING WHOS IN THE CARPOOL
//TODO ADD/FINISH Carpool applicant approval view for admin

function isPassenger($mysqli, $carpool_id, $uid){
  $retVal = false;
  if($passenger_check_stmt = $mysqli->prepare("select * from passengers WHERE ride_id_fk = ? AND user_id_fk = ?")){
    $passenger_check_stmt->bind_param("ii", $carpool_id, $uid);
    $passenger_check_stmt->execute();

    $obj = $passenger_check_stmt->get_result()->fetch_object();

    if(!($obj)){
      $retVal = false;
    }else{
      $retVal = true;
    }

    $passenger_check_stmt->close();

  }else{
    echo 'Passenger check stmt failed';
  }
}
?>

<div id=listing_info>

  <?php
  //TODO SET UID FROM SESSION HERE
  $uid = 1;

  if (isset($_GET["debugUID"])) {
    $debugUID = $_GET["debugUID"];//$_POST["recommend"]
  }

  if (isset($_GET["id"])) {
    $id = $_GET["id"];//$_POST["recommend"]
  } else {
    echo 'ERROR! User id field is unset.';
    $id = 1;
  }

  if ($results_users_stmt = $mysqli->prepare("select carpool_id, carpool_creator, leave_date , created_date, from_lat , from_long , destination_lat, destination_long, details, open_to_passengers FROM rides WHERE carpool_id = ?")) {

    $results_users_stmt->bind_param("i", $id);
  	$results_users_stmt->execute();
    //printf("Error: %d.\n", $results_users_stmt->errno);

    $obj = $results_users_stmt->get_result()->fetch_object();
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

    $results_users_stmt->close();

  } else {
    echo 'SQL Prepare failed.';
  }

  ?>

</div>

  <?php
    echo 'DEBUG debugUID cases: 1 == passenger (only sees passengers), 2 == admin (sees passengers, can accept people), 3 == no privledge user. can only apply';
  //TODO implement session user_id usage
  //TODO REMOVE DEBUG VARS
  //TODO REMOVE DEBUG WHEN MERGING INTO MASTER
  //TODO TEST THESE CASES WITH UID SET AT TOP


  //isPassenger($mysqli, $carpool_id, $uid) === true
  //TODONOW REMOVE DEBUGUID

  //$debugUID == 1 || $debugUID == 2 ||

  if (isset($_GET["id"])) {
  	$carpool_id = $_GET["id"];
  } else {
  	echo "No carpool id provided";
  }

  if (isset($_GET["debugUID"])) {
  	$debugUID = $_GET["debugUID"];
  } else {
  	echo "No debugUID provided";
  }

  if(isPassenger($mysqli, $carpool_id, $uid) === true){//PASSENGER CASE
    //TODO TODONOW FINISH THIS
    echo '<div id=passengers>';
    echo 'PASSENGERS:';
    echo "<table class='Passengers'><tr><th>User ID<th></tr>";
    if($passengers_stmt = $mysqli->prepare("select * from passengers WHERE ride_id_fk = ?")){
      $passengers_stmt->bind_param("i", $carpool_id);
      $passengers_stmt->execute();

      $passenger_results = $passengers_stmt->get_result();

      while($obj = $passenger_results->fetch_object()){
              echo "<tr>";
              echo "<td>".htmlspecialchars($obj->user_id_fk)."</td>";
              echo "</tr>";
      }
      //TODO SPIT OUT ROWS

      $passengers_stmt->close();

    }else{
      echo 'Passenger check stmt failed';
    }
    echo '</table>';
    echo '</div>';

    //TODO NOW FINISH THIS
    //$uid === $carpool_creator
    if($uid === $carpool_creator){//ADMIN SUBCASE
      ?>
      <div id=applicant_review_interface>
        <div id=applicants>
          <?php

          //`app_id`, `ride_id_fk`, `applicant_uid_fk`, `decision_status`, `description`
          //convert to li factory
          echo '<table>';
          if ($apps_stmt = $mysqli->prepare("SELECT * FROM `carpool_applications` WHERE decision_status = 'PENDING' AND ride_id_fk = ?")) {
              $apps_stmt->bind_param("i", $id);
              $apps_stmt->execute();

              $app_rows = $apps_stmt->get_result();
              while($obj = $app_rows->fetch_object()){
                //print_r($obj);
                echo "<tr>";
                //TODO Make this link to their user page
                  echo "<td>".htmlspecialchars($obj->ride_id_fk)."</td>";
                  echo "<td>".htmlspecialchars($obj->description)."</td>";
                  ?>
                  <td>
                    <form method="post" action='decision.php' class="decision_accept">

                      <button type=hidden value=<?php echo htmlspecialchars($obj->app_id);?> name="app_id">Accept</button>
                      <input type=hidden value='ACCEPTED' name="decision_status">
                    </form>
                  </td>
                  <td>
                  <form method="post" action='decision.php' class="decision_reject">

                    <button type=hidden value=<?php echo htmlspecialchars($obj->app_id);?> name="app_id">Reject</button>
                    <input type=hidden value='REJECTED' name="decision_status">
                  </form>
                  </td>
                  <?php
                echo "</tr>";
              }
              $apps_stmt->close();
          }else{
            echo 'debug FAIL on prep for applicants fetch';
            printf("Error: %s\n", $mysqli->error);

          }
          echo '</table>';
          ?>
        </div>
      </div>
      <?php
    }
  }else{//Non Passenger Case, Let them apply
    ?>
    <div id=listing_app>
      <form method="post" action='apply.php' class="inform">
      <ul>
        <li><label>Application Description:<br></label> <textarea name="description" rows="4" cols="50" onKeyDown="charLimit(this.form.description, this.form.countdown, 1000);" onKeyUp="charLimit(this.form.description, this.form.countdown, 1000);" placeholder="Enter application description."></textarea>
        <br><input readonly type="text" name="countdown" value="1000"> characters left
        <br><input type=number name="ride_id" value=<?php echo $id; ?>
        <br><input type=number name="uid" value=<?php echo $uid; ?>
        <li><input type=submit name="Submit application">
      </ul>
      </form>
    </div>

    <?php
  }

mysqli_close($mysqli);

}

include("_footer.php");
?>
