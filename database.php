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
      echo "<br>Game ID: " . $gameID[0] . "<br>";
      return $gameID[0];
    } else {
      echo "Error: " . $stmt . "<br>" . $GLOBALS['conn']->error;
    }
  }

  function insertMove($player, $move) {
    $id = getGameIdFromNumber($player);
    $stmt = "INSERT INTO moves (`$move`, `game_id`) VALUES ($player, $id)
              ON DUPLICATE KEY UPDATE `$move` = VALUES(`$move`)";
    if ($GLOBALS['conn']->query($stmt) === TRUE) {
      echo "Move inserted successfully!";
    } else {
      echo "Error: " . $stmt . "<br>" . $GLOBALS['conn']->error;
    }
  }

  function checkForVictory($player) {
    $id = getGameIdFromNumber($player);
    $stmt = "SELECT * FROM moves WHERE `game_id` = $id";
    $query = $GLOBALS['conn']->query($stmt);

    if ($query !== false) {
      $result = $query->fetch_assoc();
      $array = [];
      foreach ($result as $row) {
        array_push($array, $row);
        echo $row . " / ";
        if ($row != $player) {
          echo "empty";
        }
      }

      if ($array[1] == $player && $array[2] == $player && $array[3]) {
        echo "Victory! Top horizontal line";
      }
      else if ($array[4] == $player && $array[5] == $player && $array[6]) {
        echo "Victory! Middle horizontal line";
      }
      else if ($array[7] == $player && $array[8] == $player && $array[9]) {
        echo "Victory! Bottom horizontal line";
      }
      else if ($array[1] == $player && $array[4] == $player && $array[7]) {
        echo "Victory! Left vertical line";
      }
      else if ($array[2] == $player && $array[5] == $player && $array[8]) {
        echo "Victory! Middle vertical line";
      }
      else if ($array[3] == $player && $array[6] == $player && $array[9]) {
        echo "Victory! Right vertical line";
      }
      else if ($array[1] == $player && $array[5] == $player && $array[9]) {
        echo "Victory! Upper left to bottom right diagonal line";
      }
      else if ($array[7] == $player && $array[5] == $player && $array[3]) {
        echo "Victory! Bottom left to upper right diagonal line";
      }
    } else {
      echo "Error: " . $stmt . "<br>" . $GLOBALS['conn']->error;
    }
  }

  startGame('123', '456');
  // getGameIdFromNumber('34693');
  insertMove('123', '11');
  insertMove('123', '22');
  insertMove('123', '33');
  checkForVictory('123');
  // insertMove('07934009548', '22',)

?>
