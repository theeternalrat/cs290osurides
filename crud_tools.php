<?php

function crud_dispdiv_create($div_name,$field_name,$field_value){
  echo '<div id='.htmlspecialchars($div_name);
    echo "<p> ".htmlspecialchars($field_name)." : ".htmlspecialchars($field_value)."</p>";
  echo '</div>';
}

?>
