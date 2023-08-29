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
        <p style="text-align: left;"><a href="dbicw2-deleteActor.php">Delete an actor</a></p>

        <?php //start of php


        $db_host = "mysql.cs.nott.ac.uk"; // Database credentials
        $db_name = "psyog2_COMP1004";
        $db_user = "psyog2_COMP1004";
        $db_pass = "^56diMlcX#6z";

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name); //attempt connection
        if ($conn->connect_errno) {
          die("Sorry, there was a problem accessing the database.\nError: " . $conn->connect_errno . "<br><a href=\"dbicw2.html\">Return to home</a></body></html>");
        }        

        $query = "SELECT mvTitle,mvGenre,mvAct FROM Movie;"; //assemble query to fetch all movies on db
        if(!$stmt = $conn->prepare($query)) {
          die("Sorry, SQL statement execution was unsuccessful.<br><a href=\"dbicw2.html\">Return to home</a>");
        }

        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($Title,$Genre,$Actor);

        
        
        ?> <!-- end of php -->


        <table id="search">
          <tr> <!-- header row -->
            <th>Title</th><th>Genre</th><th>Actor</th><th>Delete</th>
          </tr>
          <?php // start of php for outputting search results
          if($stmt->num_rows() == 0) {
            echo "<tr><td colspan=3>No results.</td></tr>";
          }
          while ($stmt->fetch()) {
            $dellink = str_replace(' ', '+', $Title);
            echo "<tr><td>$Title</td><td>$Genre</td><td>$Actor</td>" . 
            "<td><a href=\"http://avon.cs.nott.ac.uk/~psyog2/dbicw2-delete2.php?del=$dellink\"><img src=\"dbicw2-delete.png\" width=\"30\" height=\"30\"></a></td></tr>";
          }
          ?>
        </table>
      </div>
    
    </div>

  </body>

</html>