<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';

  $dt = new db();
  $dt->connect();

  $opQueries = new operationQueries();

  $rawBody = file_get_contents("php://input"); // Read body
  session_start();
  if($rawBody != "" && isset($_SESSION['login_user'])) {
    $data = json_decode($rawBody);
    $accessType = $data->access;
    $features = $data->features;
    $selectedfeatures = $data->selectedfeatures;
    $role_id = $data->role_id;
    $org_id = $data->orgId;
    $all_feature_names = explode(',', $features);
    $selected_feature_names = explode(',', $selectedfeatures);

    $sql = $opQueries->getRoleDetails($role_id,$org_id);
    $result = $dt->query($sql);
    if ($dt->getRows($result) > 0) {
        foreach ($result as $row) {
            $role_name= $row['role_name'];
            break;
        }

        foreach($all_feature_names as $feature){
           $sql = $opQueries->deleteRoleEntry($role_id, $org_id, $feature);
           $result = $dt->query($sql);
        }

        foreach($selected_feature_names as $selected_feature){
           $sql = $opQueries->createRole($org_id, $role_name, $selected_feature, $accessType, "'".$role_id."'");
           $result = $dt->query($sql);
        }

   //$sql = $opQueries->updateRole($accessType, $feature, $role_id);
   //$result = $dt->query($sql);
   //}

   if($dt->affected()>0){
      echo '{"success":"1"}';
   }
   else{
    echo '{"success":"0", "error":"'.$dt->db_error().'"}';
   }
   }
   else{
       echo '{"success":"0", "error":"No role found."}';
   }
  }
  $dt->close();
?>
