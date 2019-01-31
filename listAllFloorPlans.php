<?php
header('Access-Control-Allow-Origin: *');

require_once 'db.php';
$dt = new db();
$dt->connect();
session_start();

$rawBody = file_get_contents("php://input"); // Read body

if ($rawBody != "" && isset($_SESSION['login_user'])) {
  $data = json_decode($rawBody);
  $user_name = $data->username;

  $sql = "select name from floorPlan where user_name='".$user_name."'";

  $result = $dt->query($sql);
  if ($dt->getRows($result) > 0) {
        $fnames="[";
        // output data of each row
        foreach ($result as $row) {
            //$myfile = readfile("C:\wamp64\www\\".$row['name'].".txt");
            $myfile = file_get_contents("/var/www/html/".$row['name'].".txt", true);
            $fnames = $fnames.'{"'.$row['name'].'":"'.$myfile.'"},';
        }
        $fnames = rtrim($fnames,',');
        $fnames=$fnames."]";
        echo $fnames;
  } else {
        echo "";
  }
}
  $dt->close();
?>
