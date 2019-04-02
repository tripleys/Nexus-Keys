<?php

header('Access-Control-Allow-Origin: *');

$after = $_GET['after'];

// check if `after` is numeric to avoid sql injection
if (!is_numeric($after)) {
    echo 'INVALID_DATA_TYPE';
    exit;
}

$after = round($after);

$db_host = '';
$db_user = '';
$db_pass = '';
$db_name = '';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($mysqli -> connect_errno) {
    echo "null";
    exit;
}

$query = "SELECT * FROM nexuskeys WHERE after > $after ORDER BY id DESC LIMIT 10";

if (!$result = $mysqli->query($query)) {
    echo "null";
    exit;
}

if ($result->num_rows === 0) {
    echo "null";
    exit;
}

$results = array();

while($row = $result->fetch_assoc()) {
  $results[] = array(
      'dungeon' => $row['dungeon'],
      'server' => $row['server'],
      'time' => $row['time'],
      'after' => $row['after'],
      'map' => array(
        'x' => $row['x'],
        'y' => $row['y']
      )
  );
}

echo json_encode($results);
$result->free();
$mysqli->close();
exit;