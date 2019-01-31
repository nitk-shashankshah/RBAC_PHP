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
    $role_id = $data->roleId;
    $role_name=$data->roleName;

    $sql = $opQueries->updateRoleName($role_name, $role_id);

    $result = $dt->query($sql);
    if($dt->affected() >0){
       echo '{"success":"1"}';
    }
    else{
       echo '{"success":"0","error":"'.$dt->db_error().'"}';
    }
  }
  $dt->close();
?>
