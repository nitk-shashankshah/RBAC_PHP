<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';

  $dt = new db();
  $dt->connect();
  session_start();

  $opQueries = new operationQueries();

  $rawBody = file_get_contents("php://input"); // Read body
  if($rawBody != "" && isset($_SESSION['login_user'])) {
    $data = json_decode($rawBody);
    $access = $data->access;
    $feature = $data->feature;
    $roleName = $data->roleName;
    $org_id = $data->orgId;
    $feature_names = explode(',', $data->feature);

    $sql = $opQueries->createRole($org_id, $roleName, $feature_names[0], $access,"uuid()");

    $res = $dt->query($sql);

    if($dt->affected() >=0) {
        $sql = $opQueries->selectRole($org_id, $roleName, $feature_names);
        $result = $dt->query($sql);

        if ($dt->getRows($result) > 0) {
              foreach ($result as $row) {
                $x = $row["role_id"];
                $c=0;
                foreach ($feature_names as $feature) {
                   if ($c>0){
                     $sq = $opQueries->createRole($org_id, $roleName, $feature, $access,"'".$x."'");
                     $dt->query($sq);
                   }
                   $c++;
                }
              }
        }
        echo '{"success":"1","role_id":"'.$x.'"}';
    }
    else
        echo '{"success":"0","error":"'.$dt->db_error().'"}';
  }
  $dt->close();
?>
