<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';

  $dt = new db();
  $dt->connect();

  $opQueries = new operationQueries();
  session_start();
  $rawBody = file_get_contents("php://input"); // Read body

  if($rawBody != "" && isset($_SESSION['login_user'])) {
    $data = json_decode($rawBody);
    $admin_id = $data->admin;
    $org_id = $data->orgId;

    $sql = $opQueries->updateAdmin($admin_id, $org_id);
    $result = $dt->query($sql);

    if($dt->affected() >0){
       echo '{"success":"1", "error":"'.$dt->db_error().'"}';
    }else{
       echo '{"success":"0", "error":"Admin could not be updated."}';
    }
  }
  $dt->close();
?>
