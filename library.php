<?php
  function display_table($rows) {
    echo "<table border=1>"; //starts table with borders

    echo "<tr>"; //new row
    foreach($rows[0] as $key => $item) { //goes through all of the data in the first row
      echo "<th>$key</th>"; //makes table headers from this first row
    }
    echo "</tr>";

    foreach($rows as $row) { //goes through all rows
      echo "<tr>"; //makes a new row
      foreach($row as $key => $item) { //goes through the data in the row
        echo "<td>$item</td>"; //makes table data for the item
      }
      echo "</tr>";
    }

    echo "</table>";
  }


  $username = ""; //my username
  $password = ""; //my password
?>
