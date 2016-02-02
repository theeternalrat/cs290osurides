<?php
include("_header.php");
include("db_init.php");

?>
<div id=user_bio>
  <?php

  //TODO ADD CSS
  //TODO use query_id
  $results_users = $mysqli->query("select avatar_url_rel,name,bio,email FROM users WHERE pk_id = 1");
  $obj = $results_users->fetch_object();
  if(!($obj)){
    echo 'ERROR! NO SQL RESULT OBJECT';
  }

  $user_avatar_url_rel  = $obj->avatar_url_rel;
  $user_name        = $obj->name;
  $user_bio         = $obj->bio;
  $user_email       = $obj->email;

  $query_id = $_GET['q'];
  ?>

  <div id=avatar>
    <img src="imgs/".$user_avatar_url_rel. "alt="Mountain View" style="width:304px;height:228px;">
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
  if ($result_reviews = $mysqli->query("select driver_enum,score,recommend,description from reviews")) {
      while($obj = $result_reviews->fetch_object()){
              echo "<tr>";
              echo "<td>".htmlspecialchars($obj->driver_enum)."</td>";
              echo "<td>".htmlspecialchars($obj->score)."</td>";
              echo "<td>".htmlspecialchars($obj->recommend)."</td>";
              echo "<td>".htmlspecialchars($obj->description)."</td>";
              echo "</tr>";
      }

      $result_reviews->close();
  }
  echo "</table>";
  ?>
</div>


<?php
include("_footer.php");
?>
