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
        <h1>Movie Added</h1>

        <?php //start of php

        $title = $_SESSION['title'];
        $genre = $_SESSION['genre'];
        $actor = $_SESSION['actor'];
        echo "<hr>";

        $db_host = "mysql.cs.nott.ac.uk"; // Database credentials
        $db_name = "psyog2_COMP1004";
        $db_user = "psyog2_COMP1004";
        $db_pass = "^56diMlcX#6z";

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name); //attempt connection
        if ($conn->connect_errno) {
          die("Sorry, there was a problem accessing the database.\nError: " . $conn->connect_errno . "<br><a href=\"dbicw2.html\">Return to home</a></body></html>");
        }
        
        $actQuery = "SELECT mvTitle FROM Movie WHERE mvAct='$Actor';"; // check if actor already exists
        if(!$stmtAct = $conn->prepare($actQuery)) {
          die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
        }

        $stmtAct->execute();
        $stmtAct->store_result();
        $stmtAct->bind_result($actTitle);

        if($stmtAct->num_rows() == 0) { //if actor doesnt already exist
          // Add actor to Actor table
          $queryAdd = "INSERT INTO Actor (actName) VALUES (\"$actor\");";
          if(!$stmtAdd = $conn->prepare($queryAdd)) {
            die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
          }
          $stmtAdd->execute();
        }

        // Add movie to Movie table
        $queryAdd = "INSERT INTO Movie (mvTitle, mvGenre, mvAct, actID)
        VALUES (\"$title\", \"$genre\", \"$actor\", (SELECT actID FROM Actor WHERE actName=\"$actor\"));";
        if(!$stmtAdd = $conn->prepare($queryAdd)) {
          die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
        }
        $stmtAdd->execute();



        $query = "SELECT mvTitle,mvGenre,mvAct FROM Movie;"; //assemble query with 'starts with' wildcard
        if(!$stmt = $conn->prepare($query)) {
          die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
        }

        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($Title,$Genre,$Actor);
        
        ?> <!-- end of php -->


        <table id="add">
          <tr> <!-- header row -->
            <th>Title</th><th>Genre</th><th>Actor</th>
          </tr>
          <?php // start of php for outputting search results
          if($stmt->num_rows() == 0) {
            echo "<tr><td colspan=3>No results.</td></tr>";
          }
          while ($stmt->fetch()) {
            echo "<tr><td>$Title</td><td>$Genre</td><td>$Actor</td></tr>";
          }
          ?>
        </table>
      </div>
    
    </div>

  </body>
</html>