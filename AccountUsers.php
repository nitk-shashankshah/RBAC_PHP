<?php
session_start();
header('Access-Control-Allow-Origin: *');
require_once 'db.php';
require_once 'operationQueries.php';

$dt = new db();
$dt->connect();

$opQueries = new operationQueries();

$rawBody = file_get_contents("php://input");

if ($rawBody != "" && isset($_SESSION['login_user'])) {  
  $data = json_decode($rawBody);
  if (isset($data->orgId)){
    $org = $data->orgId;
    $sql = $opQueries->getTenantCount($org);
  }
  else{
    $sql = $opQueries->getSuperTenantCount();
  }

  $res="[";
  $result = $dt->query($sql);

  if ($result->num_rows > 0) {
      foreach ($result as $row) {
        $x = '{"organization":"'.$row["org_name"].'","id":"'.$row["org_id"].'","users":"'.$row["count(*)"].'"}';
        $res = $res.$x.",";
      }
      $res = rtrim($res,',');
      $res=$res."]";
      echo $res;
  } else {
      echo "";
  }
}
$dt->close();
?>
