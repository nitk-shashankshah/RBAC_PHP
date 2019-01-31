<?php
    header('Access-Control-Allow-Origin: *');
    require_once 'db.php';
    require_once 'operationQueries.php';

    $dt = new db();
    $dt->connect();

    $opQueries = new operationQueries();

    $rawBody = file_get_contents("php://input"); // Read body

    if($rawBody != ""  && isset($_SESSION['login_user']) {
      $data = json_decode($rawBody);
    	$email = $data->email;

      if (filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
        $email = $data->email;
      } else{
        echo "email is not valid";
        exit;
      }

      $sql = $opQueries->getUser($email);
      $result = $dt->query($sql);
      if ($dt->getRows($result) > 0) {
      foreach ($result as $row) {
        if ($row['email_addr'])
        {
        // Create a unique salt. This will never leave PHP unencrypted.
        $salt = "498#2D83B631%3800EBD!801600D*7E3CC13";
        // Create the unique user password reset key
        $password = hash('sha512', $salt.$row["email_addr"]);
        // Create a url which we will direct them to reset their password
        $pwrurl = "http://localhost:4200/confirm?email=".$row['email_addr']."&q=".$password;
        // Mail them their key
        $mailbody = "Dear user,\n\nIf this e-mail does not apply to you please ignore it. It appears that you have requested a password reset at our website www.yoursitehere.com\n\nTo reset your password, please click the link below. If you cannot click it, please paste it into your web browser's address bar.\n\n" . $pwrurl . "\n\nThanks,\nThe Administration";
        //mail($userExists["email_addr"]'', "www.yoursitehere.com - Password Reset", $mailbody);
        //mail('nitk_shashankshah@yahoo.co.in', "www.yoursitehere.com - Password Reset", $mailbody);
        mail($email,"Subject",  $mailbody ,"From:nitk.shashankshah@gmail.com");
        echo "1";
       }
       else
        echo "0";
     }
     }else{
        echo "0";     
     }
    }
    $dt->close();
?>
