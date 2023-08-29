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
        <h1>Delete Movie</h1>

        <?php //start of php

        $delID = intval($_SESSION['delID']); // for next page

        $db_host = "mysql.cs.nott.ac.uk"; // Database credentials
        $db_name = "psyog2_COMP1004";
        $db_user = "psyog2_COMP1004";
        $db_pass = "^56diMlcX#6z";

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name); //attempt connection
        if ($conn->connect_errno) {
          die("Sorry, there was a problem accessing the database.\nError: " . $conn->connect_errno . "<br><a href=\"dbicw2.html\">Return to home</a></body></html>");
        }
        

        $query = "SELECT mvTitle,mvGenre,mvAct FROM Movie WHERE mvID = $delID;"; //fetch movie details for deletion
        if(!$stmt = $conn->prepare($query)) {
          die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
        }

        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($Title,$Genre,$Actor);
        $stmt->fetch(); // only one result to fetch now

        $queryDel = "DELETE FROM Movie WHERE mvID=$delID;"; //delete movie from Movie - select unique with ID
        if(!$stmtDel = $conn->prepare($queryDel)) {
          die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
        }
        $stmtDel->execute();

        
        $actQuery = "SELECT mvTitle FROM Movie WHERE mvAct='$Actor';"; // check if actor appears in other movies before deleting
        if(!$stmtAct = $conn->prepare($actQuery)) {
          die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
        }

        $stmtAct->execute();
        $stmtAct->store_result();
        $stmtAct->bind_result($actTitle);

        if($stmtAct->num_rows() <= 1) { //if only appears in one or no movies
          $queryDel = "DELETE FROM Actor WHERE actName=\"$Actor\";"; //delete actor from Actor
          if(!$stmtDel = $conn->prepare($queryDel)) {
            die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
          }          
          $stmtDel->execute();
        }

        ?> <!-- end of php -->


        <table id="search">
          <tr> <!-- header row -->
            <th>Title</th><th>Genre</th><th>Actor</th>
          </tr>
          <?php // start of php for outputting search results
          $delTrue = "This";
          if($stmt->num_rows() == 0) {
            echo "<tr><td colspan=3>No results.</td></tr>";
            $delTrue = "No"; //for deletion message below table
          }
          else { 
            echo "<tr><td><strike>$Title</strike></td><td><strike>$Genre</strike></td><td><strike>$Actor</strike></td></tr>";
          }
          ?>
        </table>
        <br>
        <table align="center">
          <tr>
            <td colspan=2 style="text-align:center"><?php echo $delTrue; ?> movie was deleted from the database.<br><a href="dbicw2.html">Return home</a></td>
        </tr>
        </table>

      </div>
    </div>
  </body>
</html>