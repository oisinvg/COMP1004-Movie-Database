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
        <h1>Add Movie</h1>

        <?php //start of php

        $title = $_GET['title'];
        $genre = $_GET['genre'];
        $actor = $_GET['actor'];

        $_SESSION['title'] = $title; // for next page
        $_SESSION['genre'] = $genre;
        $_SESSION['actor'] = $actor;


        ?>

        <table id="search">
          <tr> <!-- header row -->
            <th>Title</th><th>Genre</th><th>Actor</th>
          </tr>
          <tr>
            <td><?php echo $title; ?></td>
            <td><?php echo $genre; ?></td>
            <td><?php echo $actor; ?></td>
          </tr>
        </table>

        <table align="center">
          <tr>
            <td colspan=2>Add this movie?</td>
        </tr>
        <tr>
            <td><form action="dbicw2-add2.php"><input type="submit" value="Yes"></form></td>
            <td><form action="dbicw2-add.html"><input type="submit" value="Cancel"></form></td>
          </tr>
        </table>

      </div>
    </div>
  </body>
</html>