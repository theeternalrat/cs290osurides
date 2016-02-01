<?php
include("_header.php");
?>
<div id=user_bio>
  <?php

  $results_users = $mysqli->query("select avatar_url,name,bio,email");
  if(!($obj = $results_users->fetch_object())){
    echo 'ERROR!';
  }
  $user_avatar_url  = $obj->avatar_url;
  $user_name        = $obj->name;
  $user_bio         = $obj->bio;
  $user_email       = $obj->email;
  ?>

  <div id=avatar>
    <img src="pic_mountain.jpg" alt="Mountain View" style="width:304px;height:228px;">
      <?php echo "<p>".htmlspecialchars($user_avatar_url)."</p>"?>
  </div>
  <div id=info>
    <div id=name>
      <?php echo "<p>".htmlspecialchars($user_name)."</p>"?>
    </div>
    <div id=bio>
      <?php echo "<p>".htmlspecialchars($user_bio)."</p>"?>
    </div>
    <div id=email>
      <?php echo "<p>".htmlspecialchars(user_email)."</p>"?>
    </div>
  </div>
</div>

<div id=reviews>
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

      $result->close();
  }
  echo "</table>";
</div>


<?php
include("_footer.php");
?>
