<?php
header('Access-Control-Allow-Origin: *');
session_start();
if (isset($_SESSION['auth'])){
 if ($_SESSION['auth'] == 0) {
	echo '{"user":"none", "auth":"0"}';
 } else {
	//if authenticated, output json
	echo '{"user":"'.$_SESSION['user'].'", "auth":"'.$_SESSION['auth'].'"}';
 }
}
else{
  echo '{"user":"none", "auth":"0"}';
}
?>
