<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';
  $opQueries = new operationQueries();
  session_start();

  $dt = new db();
  $dt->connect();

  $rawBody = file_get_contents("php://input"); // Read body
  if ($rawBody != "" && isset($_SESSION['login_user'])) {
    $data = json_decode($rawBody);
    $user = $data->user;


  $sql = $opQueries->checkUser($user);

  $res="[";
  $result = $dt->query($sql);
  if ($dt->getRows($result) > 0) {
    echo "{\"exists\":true}";
  } else {
    echo "{\"exists\":false}";
  }
}else{
  echo "{\"exists\":true}";
}
  $dt->close();
?>
