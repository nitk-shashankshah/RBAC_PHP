<?php
header('Access-Control-Allow-Origin: *');

require_once 'db.php';
$dt = new db();
$dt->connect();
// Was the form submitted?
$rawBody = file_get_contents("php://input"); // Read body

if($rawBody != "" && isset($_SESSION['login_user']) {
    $data = json_decode($rawBody);
    $email = $data->email;
    $password = $data->password;
    $confirmpassword = $data->confirmpassword;
    $hash =  $data->q;
    $salt = "498#2D83B631%3800EBD!801600D*7E3CC13";
    $resetkey = hash('sha512', $salt.$email);

    if ($resetkey == $hash || $hash=="")
    {
        if ($password == $confirmpassword)
        {
            $sql = 'UPDATE users SET password = SHA1(\''.$password.'\') WHERE email_addr = \''.$email.'\'';
            $dt->query($sql);
            if ($dt->affected()>0)
              echo "Your password has been successfully reset.";
            else
              echo "Your password could not be updated. New password should be different from the existing password. Please try with a new password.";
        }
        else
            echo "Your password's do not match.";
    }
    else
        echo "Your password reset key is invalid.";
}
?>
