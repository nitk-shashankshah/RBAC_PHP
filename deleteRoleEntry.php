<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';

  $dt = new db();
  $dt->connect();

  $opQueries = new operationQueries();
  $rawBody = file_get_contents("php://input"); // Read body

  if($rawBody != "") {
    $data = json_decode($rawBody);
    $role = $data->role;
    $feature = $data->feature;
    $access = $data->access;
    $org_id = $data->orgId;

    $sql = $opQueries->deleteRoleEntry($role, $org_id, $feature, $access);

    $result = $dt->query($sql);

    if($dt->affected() >0){
       echo '{"success":"1", "error":"Role Entry deleted."}';
    }
    else{
       echo '{"success":"0", "error":"'.$dt->db_error().'"}';
    }
  }
  $dt->close();
?>
