<?php
  header('Access-Control-Allow-Origin: *');

  $rawBody = file_get_contents("php://input");
  if($rawBody != "") {
      $data = json_decode($rawBody);
      $op = $data->operation;
      $entity = $data->entity;
      $value = $data->value;
      $timestamp = $data->timestamp;
      $isSuper = $data->isSuper;
      $user = $data->user;
      $status = $data->status;
      $role = $data->role;
      $pageDetail = $data->pageDetail;
      $delimiter = $data->delimiter;
      $orgName = $data->orgName;
      $mydate=getdate(date("U"));

      mkdir("/var/logs/".$mydate[month]."_".$mydate[mday]."_".$mydate[year], 0755, true);

      if ($isSuper==true){
         $fp = fopen("/var/logs/".$mydate[month]."_".$mydate[mday]."_".$mydate[year]."/super_admin_log.txt", "a") or die("Unable to open file!");
      }
      else{
         $fp = fopen("/var/logs/".$mydate[month]."_".$mydate[mday]."_".$mydate[year]."/".$orgName.".txt", "a") or die("Unable to open file!");
      }

      if ($fp && flock ($fp, LOCK_EX)) {
          $txt = $timestamp.$delimiter.$user.$delimiter.$role.$delimiter.$pageDetail.$delimiter.$op.$delimiter.$entity." ".$value.$delimiter.$status."\r\n";
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
