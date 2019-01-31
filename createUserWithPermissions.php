<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';

  $dt = new db();
  $dt->connect();
  session_start();

  $opQueries = new operationQueries();

  $rawBody = file_get_contents("php://input"); // Read body

  if ($rawBody != "" && isset($_SESSION['login_user'])) {
    $data = json_decode($rawBody);
    $user_name = $data->user;
    $email_id = $data->emailId;
    $org_id = $data->orgId;

    $sql = $opQueries->createUser($user_name,$email_id,$org_id);
    $result = $dt->query($sql);

    if($dt->affected() >=0){
      $sql = $opQueries->getUser($email_id);
      $result = $dt->query($sql);
      if ($dt->getRows($result) > 0) {
      foreach ($result as $row) {
        echo '{"success":"1", "admin":"'.$row['user_id'].'"}';
      }
      }else{
        echo '{"success":"0", "error":"Some error occured."}';
      }
    }
    else {
      echo '{"success":"0", "error":"'.$dt->db_error().'"}';
    }
  }
  $dt->close();
?>
