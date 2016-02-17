<?php
include("_header.php");
include("db_init.php");

?>
<div id=user_bio>
  <?php

  if (isset($_GET["q"])) {
  	$id = $_GET["q"];//$_POST["recommend"]
  } else {
  	echo 'ERROR! User id field is unset.';
	$id = 1;
  }

  if ($results_users = $mysqli->prepare("select avatar_url_rel,name,bio,email FROM users WHERE pk_id = ?")) {
    $results_users->bind_param("i", $id);
  	$results_users->execute();

    $obj = $results_users->get_result()->fetch_object();
    if(!($obj)){
      echo 'ERROR! NO SQL RESULT OBJECT';
    }

    $user_avatar_url_rel  = $obj->avatar_url_rel;
    $user_name        = $obj->name;
    $user_bio         = $obj->bio;
    $user_email       = $obj->email;


    $results_users->close();

  }

  ?>

  <div id=avatar>
    <img src="imgs/<?php echo $user_avatar_url_rel ?>"alt="Mountain View" style="width:304px;height:228px;">
      <?php echo "<p> Avatar: ".htmlspecialchars($user_avatar_url_rel)."</p>"?>
  </div>
  <div id=info>
    <div id=name>
      <?php echo "<p> User's Name: ".htmlspecialchars($user_name)."</p>"?>
    </div>
    <div id=bio>
      <?php echo "<p> Bio: ".htmlspecialchars($user_bio)."</p>"?>
    </div>
    <div id=email>
      <?php echo "<p> Email Address: ".htmlspecialchars($user_email)."</p>"?>
    </div>
  </div>
</div>


<div id=reviews>
  <?php
  echo "<table class='reviews'><tr><th>Driver or Passewnger<th>Score<th>Recommend?<th>Description<th></tr>";
  if ($result_reviews_stmt = $mysqli->prepare("select driver_enum,score,recommend,description from reviews WHERE PK_ID = ?")) {
      $result_reviews_stmt->bind_param("i", $id);
      $result_reviews_stmt->execute();
      $result_reviews = $result_reviews_stmt->get_result();
      while($obj = $result_reviews->fetch_object()){
              echo "<tr>";
              echo "<td>".htmlspecialchars($obj->driver_enum)."</td>";
              echo "<td>".htmlspecialchars($obj->score)."</td>";
              echo "<td>".htmlspecialchars($obj->recommend)."</td>";
              echo "<td>".htmlspecialchars($obj->description)."</td>";
              echo "</tr>";
      }

      $result_reviews_stmt->close();
  }
  echo "</table>";
  ?>
</div>


<?php
mysqli_close($mysqli);
include("_footer.php");
?>
