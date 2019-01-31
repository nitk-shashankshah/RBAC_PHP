<?php
header('Access-Control-Allow-Origin: *');
require_once 'db.php';
require_once 'operationQueries.php';
session_start();
if (isset($_SESSION['login_user'])){
$dt = new db();
$dt->connect();
$opQueries = new operationQueries();

$sql = $opQueries->listFeatures();
$result = $dt->query($sql);

$res="[";
$result = $dt->query($sql);
if ($dt->getRows($result) > 0) {
     foreach ($result as $row) {
        $x = $row['feature'];
        $res = $res."\"".$x."\",";
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
