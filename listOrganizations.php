<?php
header('Access-Control-Allow-Origin: *');
require_once 'db.php';
require_once 'operationQueries.php';
session_start();

if (isset($_SESSION['login_user'])){
$dt = new db();
$dt->connect();
$opQueries = new operationQueries();
$sql = $opQueries->listOrganizations();
$res="[";
$result = $dt->query($sql);
if ($dt->getRows($result) > 0) {
     foreach ($result as $row) {
        $x = '{"id":"'.$row["org_id"].'","name":"'.$row["org_name"].'","feature":"'.$row["feature"].'","admin":"'.$row["email_addr"].'"}';
        $res = $res.$x.",";
      }
      $res = rtrim($res,',');
      $res=$res."]";
      echo $res;
} else {
      echo "";
}

$dt->close();
}
?>
