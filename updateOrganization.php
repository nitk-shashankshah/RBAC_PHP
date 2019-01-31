<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';

  $dt = new db();
  $dt->connect();

  $opQueries = new operationQueries();

  session_start();

  $rawBody = file_get_contents("php://input"); // Read body

  if($rawBody != "" && isset($_SESSION['login_user'])) {
    $data = json_decode($rawBody);
    $id = $data->id;
    $features = $data->features;
    $feature_names = explode(',', $data->features);

    $all_feature_names=array("LBS","SUBSCRIBER TRACING","ADMIN","SUPER USER");

    $sql = $opQueries->deleteOrgFeature($id);
    $res1 = $dt->query($sql);

    foreach ($all_feature_names as $f) {
      $flg=false;
      foreach ($feature_names as $f2){
          if ($f==$f2)
            $flg=true;
      }
      if ($flg==false){
         $sql_2 = $opQueries->deleteRolesEntriesWithFeature($id, $f);
         $res_2 = $dt->query($sql_2);

         if ($f=="SUBSCRIBER TRACING"){
           $sql_3 = $opQueries->deleteGroups($id);
           $res_3 = $dt->query($sql_3);
         }
      }
    }

    $sql_3 = $opQueries->listOrgRoles($id);
    $res_3 = $dt->query($sql_3);
    if ($dt->getRows($res_3) > 0) {
      foreach ($res_3 as $row3) {
        if ($row3['role_name']=='ADMIN' || $row3['role_name']=='MONITOR'){
          if ($row3['role_name']=='ADMIN')
            $accessType='READ/WRITE';
          if ($row3['role_name']=="MONITOR")
            $accessType='READ ONLY';
          foreach ($feature_names as $f2){
            $sql = $opQueries->createRole($id, $row3['role_name'], $f2, $accessType, "'". $row3['role_id']."'");
            $result = $dt->query($sql);
          }
        }
      }
    }

    $flg=false;
    foreach ($feature_names as $feature) {
        $sql = $opQueries->insertFeature($id,$feature);
        $res2 = $dt->query($sql);
        $flg=true;
    }
    if ($flg){
      echo '{"success":"1"}';
    }
    else {
      echo '{"success":"0","error":"This organization could not be saved"}';
    }
  }
  $dt->close();
?>
