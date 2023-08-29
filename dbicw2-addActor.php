<?php session_start(); ?>

<html>

  <head>
    <link rel="stylesheet" type="text/css" href="dbicw2.css">
    <title>DBICW2</title>
  </head>

  <body>

    <div id="sidebar"> <!-- sidebar with nav links-->
      <a href="dbicw2.html">Home<br><br></a>
      <a href="dbicw2-search.html">Search<br><br></a>
      <a href="dbicw2-add.html">Add Movie<br><br></a>
      <a href="dbicw2-addActor.html">Add Actor<br><br></a>
      <a href="dbicw2-delete.php">Delete Movie<br><br></a>
      <a href="dbicw2-deleteActor.php">Delete Actor<br><br></a>
    </div>

    <div id="main"> 

      <div id="content">
        <h1>Actor Added</h1>

        <?php //start of php

        $actor = $_GET['actor'];
        echo "<hr>";

        $db_host = "mysql.cs.nott.ac.uk"; // Database credentials
        $db_name = "psyog2_COMP1004";
        $db_user = "psyog2_COMP1004";
        $db_pass = "^56diMlcX#6z";

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name); //attempt connection
        if ($conn->connect_errno) {
          die("Sorry, there was a problem accessing the database.\nError: " . $conn->connect_errno . "<br><a href=\"dbicw2.html\">Return to home</a></body></html>");
        }
        
        $actQuery = "SELECT actName FROM Actor WHERE actName LIKE '$actor';"; // check if actor already exists, case insensitive
        if(!$stmtAct = $conn->prepare($actQuery)) {
          die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
        }
        $stmtAct->execute();
        $stmtAct->store_result();
        $stmtAct->bind_result($actTitle);

        if($stmtAct->num_rows() == 0) { //if actor doesnt already exist, add it
            $queryAdd = "INSERT INTO Actor (actName) VALUES (\"$actor\");";
            if(!$stmtAdd = $conn->prepare($queryAdd)) {
                die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
            }
            $stmtAdd->execute();
        }

        $query = "SELECT actName FROM Actor ORDER BY actID;"; //get full list of actors to show user - most recent last
        if(!$stmt = $conn->prepare($query)) {
          die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
        }

        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($Actor);
        
        ?> <!-- end of php -->


        <table id="add">
          <tr> <!-- header row -->
            <th>Actor</th>
          </tr>
          <?php // start of php for outputting search results
          if($stmt->num_rows() == 0) {
            echo "<tr><td colspan=3>No results.</td></tr>";
          }
          while ($stmt->fetch()) {
            echo "<tr><td>$Actor</td></tr>";
          }
          ?>
        </table>
      </div>
    
    </div>

  </body>
</html>