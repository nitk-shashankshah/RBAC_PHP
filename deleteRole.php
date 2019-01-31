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
    $role = $data->role;
    $orgId = $data->orgId;
    $q1 = $opQueries->checkRoleAssigned($role, $orgId);
    $result = $dt->query($q1);
    $num = $dt->getRows($result);
    if ($num > 0) {
       echo '{"success":"0","error":"This role cannot be deleted. It is assigned to '.$num.' users. Please unassign the role from the users if you wish to delete the role."}';
    }
    else{
    $sql = $opQueries->deleteRole($role, $orgId);
    $result = $dt->query($sql);

    if($dt->affected() >0){
       echo '{"success":"1"}';
    }
    else{
         echo '{"success":"0","error":"'.$dt->db_error().'"}';
    }
    }
  }
  $dt->close();
?>
