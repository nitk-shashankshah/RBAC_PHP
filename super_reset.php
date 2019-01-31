<?php
header('Access-Control-Allow-Origin: *');
require_once 'db.php';
$dt = new db();
$dt->connect();
// Was the form submitted?
$rawBody = file_get_contents("php://input"); // Read body
session_start();
if($rawBody != "" && isset($_SESSION['login_user'])) {
    $data = json_decode($rawBody);
    $email = $data->email;
    $sql = 'UPDATE users SET password = SHA1(\'ruckus\') WHERE email_addr = \''.$email.'\'';
    $dt->query($sql);
    if ($dt->affected()>=0)
        echo '{"success":"1"}';
    else
        echo '{"success":"0","error":"'.$dt->db_error().'"}';
}
?>
