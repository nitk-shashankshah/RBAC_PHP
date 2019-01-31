<?php
header('Access-Control-Allow-Origin: *');
require_once 'db.php';
$dt = new db();
$dt->connect();
session_start();

$rawBody = file_get_contents("php://input"); // Read body

if($rawBody != "" && isset($_SESSION['login_user'])) { //if post data
	$data = json_decode($rawBody);
	//post data from login form
	$floor_plan = $data->dataURL;
  $name= $data->name;
  $user_name = $data->username;

  $myfile = fopen($name.".txt", "w") or die("Unable to open file!");
  fwrite($myfile, $floor_plan);
  fclose($myfile);

  $sql = "INSERT INTO floorPlan (user_name, data_url, name) VALUES ('".$user_name."','', '".$name."')";
  $dt->query($sql);

  if ($dt->affected()>0) {
    echo '{"status":1}';
  } else {
    echo "Error: " . $sql . "<br>" . $dt->db_error();
  }
}
$dt->close();
?>
