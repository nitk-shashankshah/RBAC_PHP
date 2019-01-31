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

  $sql = $opQueries->listOrgRoles($org_id);

  $res="[";
  $result = $dt->query($sql);

  if ($dt->getRows($result) > 0) {
     foreach ($result as $row) {
       $x = "\"".$row['role_id']."\":\"".$row['role_name']."\"";
       $res = $res."{".$x."},";
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
