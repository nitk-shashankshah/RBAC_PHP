<?php
header('Access-Control-Allow-Origin: *');
require_once 'db.php';
require_once 'operationQueries.php';
$dt = new db();
$dt->connect();

$opQueries = new operationQueries();

$rawBody = file_get_contents("php://input"); // Read body

if($rawBody != "") {
  $data = json_decode($rawBody);
	$email = $data->email;
	$pass = $data->password;
	$auth = false;

  $sql = $opQueries->authenticate($email, $pass);
  $result = $dt->query($sql);
  session_start();
  foreach ($result as $row) {
      echo '{"org_name":"'.$row['org_name'].'","user":"'.$row['user_id'].'", "role":"'.$row['role_name'].'","counter":"'.$row['counter'].'", "org":"'.$row['org_id'].'","last_activity":"'.$row['last_activity'].'", "auth":"1"}';
      $_SESSION['login_user'] = $email;
      $auth = true;
      $user = $row['user_name'];
      $orgId = $row['org_id'];
      $lastActivity = $row['last_activity'];
      $counter = $row['counter'];
      $counter = $counter+1;
      $sq = $opQueries->updateActivity($counter, $email);
      $res = $dt->query($sq);
      break;
  }

	if(!$auth) {
		echo '{"user":"'.$email.'", "auth":"0"}';
	}
} else {
		echo '{"user":"none", "auth":"0"}';
}
$dt->close();
?>
