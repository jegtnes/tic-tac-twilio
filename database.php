<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
  // Create connection
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $database = "twilio-ticktacktoe";

  // Create connection
  $GLOBALS['conn'] = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } else {
    echo "Connected successfully";
  }


  function startGame($num1, $num2) {
    $stmt = "INSERT INTO game (num1, num2) VALUES ($num1, $num2)";
    if ($GLOBALS['conn']->query($stmt) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $stmt . "<br>" . $GLOBALS['conn']->error;
    }
  }

  function getGameIdFromNumber($num) {
    $stmt = "SELECT id FROM game WHERE num1 = '$num' OR num2 = '$num'";
    $query = $GLOBALS['conn']->query($stmt);
    if ($query !== false) {
      $gameID = $query->fetch_array();
      echo $gameID[0];
      return $gameID[0];
    } else {
      echo "Error: " . $stmt . "<br>" . $GLOBALS['conn']->error;
    }
  }

  function insertMove($player, $move) {
    $id = getGameIdFromNumber($player);
    $stmt = "INSERT INTO moves (`$move`, `game_id`) VALUES ($player, $id)
              ON DUPLICATE KEY UPDATE `$move` = VALUES(`$move`)";
    // echo $stmt;
    if ($GLOBALS['conn']->query($stmt) === TRUE) {
      echo "Move inserted successfully!";
    } else {
      echo "Error: " . $stmt . "<br>" . $GLOBALS['conn']->error;
    }
  }

  // getGameIdFromNumber('34693');
  insertMove('34693', '23');
  // startGame('34693', '9430752');
  // insertMove('07934009548', '22',)

?>
