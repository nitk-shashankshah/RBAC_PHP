<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';
  $opQueries = new operationQueries();

  session_start();

  if (isset($_SESSION['login_user'])){
  $dt = new db();
  $dt->connect();

  $org_id = $_GET["org_id"];

  $sql = $opQueries->listUsers($org_id);

  $res="[";
  $result = $dt->query($sql);
  if ($dt->getRows($result) > 0) {
     foreach ($result as $row) {
      $x = "{\"user_id\":\"".$row["user_id"]."\",\"user_name\":\"".$row["user_name"]."\",\"email_addr\":\"".$row["email_addr"]."\",\"role_id\":\"".$row["role_id"]."\",\"last_activity\":\"".$row["last_activity"]."\",\"counter\":".$row["counter"]."},";
      $res = $res.$x;
     }
     $res = rtrim($res,',');
     $res=$res."]";
     echo $res;
  } else {
        echo "[]";
  }
  $dt->close();
}
?>
