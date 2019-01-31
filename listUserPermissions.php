<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';
  $opQueries = new operationQueries();
  session_start();
  if (isset($_SESSION['login_user'])){
  $dt = new db();
  $dt->connect();
  $user_id = $_GET["user_id"];

  $sql = $opQueries->listUserPermissions($user_id);

  $res="[";
  $result = $dt->query($sql);
  if ($dt->getRows($result) > 0) {
        foreach ($result as $row) {
          $x = "{\"".$row["feature"]."\":\"".$row["access_desc"]."\"}";
          $res = $res.$x.",";
        }
        $res = rtrim($res,',');
        $res=$res."]";
        echo $res;
  } else {
        echo "";
  }
  $dt->close();
}
?>
