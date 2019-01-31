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
    $role_id = $data->roleId;
    $user_id = $data->userId;

    $roles = explode(',', $role_id);

    $sql = $opQueries->deleteUserRole($user_id);
    $result = $dt->query($sql);
    if($dt->affected() >=0){
    $sql = $opQueries->getUserRole($user_id);
    $result = $dt->query($sql);

    if ($dt->getRows($result) == 0){
      foreach($roles as $role){
        $sql = $opQueries->insertUserRole($user_id,$role);
        $result = $dt->query($sql);
      }
      if($dt->affected() >0){
        echo '{"success":"1"}';
      }
      else{
       echo '{"success":"0","error":"Role for user could not be saved."}';
      }
    }
  }else{
     echo '{"success":"0","error":"'.$dt->db_error().'"}';
  }
  }
  $dt->close();
?>
