<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';
  session_start();

  if (isset($_SESSION['login_user'])){
  $opQueries = new operationQueries();
  $dt = new db();
  $dt->connect();
  $org_id = $_GET["org_id"];

  $sql = $opQueries->listOrgGroups($org_id);

  $res="{\"".$org_id."\":";
  $result = $dt->query($sql);
  if ($dt->getRows($result) > 0) {
     $res=$res."[";
     foreach ($result as $row) {
          $x = "\"".$row['groupName']."\"";
          $res = $res.$x.",";
     }
     $res = rtrim($res,',');
     $res=$res."]";
  } else {
     $res=$res."[]";
  }
  $res=$res."}";
  echo $res;
  $dt->close();
}
?>
