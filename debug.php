<?php
  header('Access-Control-Allow-Origin: *');

  $rawBody = file_get_contents("php://input");
  if($rawBody != "") {
      $data = json_decode($rawBody);
      $timestamp = $data->timestamp;
      $user = $data->user;
      $type = $data->type;
      $pageDetail = $data->pageDetail;
      $delimiter = $data->delimiter;
      $msg = $data->msg;
      $mydate=getdate(date("U"));

      mkdir("/var/logs/".$mydate[month]."_".$mydate[mday]."_".$mydate[year], 0755, true);
      $fp = fopen("/var/logs/".$mydate[month]."_".$mydate[mday]."_".$mydate[year]."/debug.txt", "a") or die("Unable to open file!");

      if ($fp && flock ($fp, LOCK_EX)) {
          $txt = $type.$delimiter.$pageDetail."\r\n".$timestamp.$delimiter.$user."\r\n".$msg."\r\n";
          fwrite($fp, $txt);
          fclose($fp);
      	  flock ($fp, LOCK_UN);
          echo "{\"success\":\"1\"}";
      }
      else {
      	echo "Could not lock the file.";
      }
  }
?>
