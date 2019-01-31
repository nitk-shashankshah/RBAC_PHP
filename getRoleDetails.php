<?php
  header('Access-Control-Allow-Origin: *');

  require_once 'db.php';
  require_once 'operationQueries.php';
  session_start();

  $dt = new db();
  $dt->connect();
  $opQueries = new operationQueries();

  if(isset($_GET["orgId"]) && isset($_SESSION['login_user'])) {
    $org_id = $_GET["orgId"];
    $role_id = $_GET["roleId"];

    $sql = $opQueries->getRoleDetails($role_id,$org_id);
    $result = $dt->query($sql);

    $res="[";

    if ($dt->getRows($result) > 0) {
        foreach ($result as $row) {
            $res = $res."{\"feature\":\"".$row['feature']."\",\"access\":\"".$row['access_desc']."\"},";
        }
    }
    $res = rtrim($res,',');
    $res=$res."]";
    echo $res;
  }
  $dt->close();
?>
