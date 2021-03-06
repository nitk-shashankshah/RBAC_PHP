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
    $orgId = $data->orgId;
    $group = $data->group;

    $sq = $opQueries->insertOrgGroups($orgId, $group);
    $result = $dt->query($sq);

    if($dt->affected()>=0){
         echo '{"success":1}';
    }
    else {
        echo '{"success":0 , "error":"'.$dt->db_error().'"}';
    }
  }
  $dt->close();
?>
