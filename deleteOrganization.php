<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';

  $dt = new db();
  $dt->connect();

  $opQueries = new operationQueries();
  session_start();

  $rawBody = file_get_contents("php://input"); // Read body
  if ($rawBody != "" && isset($_SESSION['login_user'])) {
    $data = json_decode($rawBody);
    $org_id = $data->id;

    $sql = $opQueries->deleteOrganization($org_id);
    $result = $dt->query($sql);

    $affected = $dt->affected();

    $sql2 = $opQueries->deleteGroups($org_id);
    $result2 = $dt->query($sql2);

    if ($affected>0) {
       echo '{"success":"1"}';
    }
    else {
       echo '{"success":"0","error":"'.$dt->db_error().'"}';
    }
  }
  $dt->close();
?>
