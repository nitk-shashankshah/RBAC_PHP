<?php
  header('Access-Control-Allow-Origin: *');

  require_once 'db.php';
  require_once 'operationQueries.php';
  session_start();

  $dt = new db();
  $dt->connect();
  $opQueries = new operationQueries();

  $rawBody = file_get_contents("php://input"); // Read body

  if($rawBody != "" && isset($_SESSION['login_user'])) {
    $data = json_decode($rawBody);
    $user_id = $data->user;

    $sql = $opQueries->deleteUser($user_id);
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
