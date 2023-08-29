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

        $del = $_GET['del'];
        $_SESSION['del'] = $del; // for next page

        $db_host = "mysql.cs.nott.ac.uk"; // Database credentials
        $db_name = "psyog2_COMP1004";
        $db_user = "psyog2_COMP1004";
        $db_pass = "^56diMlcX#6z";

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name); //attempt connection
        if ($conn->connect_errno) {
          die("Sorry, there was a problem accessing the database.\nError: " . $conn->connect_errno . "<br><a href=\"dbicw2.html\">Return to home</a></body></html>");
        }
        

        $query = "SELECT mvTitle,mvGenre,mvAct,mvID FROM Movie WHERE mvTitle LIKE '%$del%' LIMIT 1;"; //select one row to ask about deletion
        if(!$stmt = $conn->prepare($query)) {
          die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
        }

        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($Title,$Genre,$Actor,$ID);
        
        ?> <!-- end of php -->


        <table id="search">
          <tr> <!-- header row -->
            <th>Title</th><th>Genre</th><th>Actor</th>
          </tr>
          <?php // start of php for outputting search results
          if($stmt->num_rows() == 0) {
            echo "<tr><td colspan=3>No results.</td></tr>";
          }
          while ($stmt->fetch()) {
            $_SESSION['delID'] = $ID; // for next page
            echo "<tr><td>$Title</td><td>$Genre</td><td>$Actor</td></tr>";
          }
          ?>
        </table>
        
        <br>

        <table align="center" style="text-align: center">
          <tr>
            <td colspan=2>Are you sure you want to<br>delete this movie?</td>
        </tr>
        <tr>
            <td><form action="dbicw2-delete3.php"><input type="submit" value="Yes"></form></td>
            <td><form action="dbicw2-delete.php"><input type="submit" value="Cancel"></form></td>
          </tr>
        </table>

      </div>
    </div>
  </body>
</html>