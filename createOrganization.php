<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  require_once 'operationQueries.php';

  $dt = new db();
  $dt->connect();
  session_start();

  $opQueries = new operationQueries();

  $rawBody = file_get_contents("php://input"); // Read body

  if($rawBody != "" && isset($_SESSION['login_user'])) {
    $data = json_decode($rawBody);
    $org_name = $data->name;
    $features = $data->features;
    $feature_names = explode(',', $data->features);

    $sql = $opQueries->getOrganization($org_name);
    $result = $dt->query($sql);

    if ($result->num_rows == 0) {
             $sq = $opQueries->addOrganization($org_name);
             $result = $dt->query($sq);

             if($dt->affected()>=0){
               $sq = $opQueries->getOrgByName($org_name);
               $result = $dt->query($sq);
               if ($result && $result->num_rows > 0){
                   foreach ($result as $row) {
		                $org_id=$row['org_id'];
                    foreach($feature_names as $feature) {
                       $sq = $opQueries->insertFeature($org_id,$feature);
                       $res = $dt->query($sq);
                    }
                    echo '{"success":1,"org_id":"'.$org_id.'"}';
                  }
               }
             }
             else {
                echo '{"success":0 , "error":"'.$dt->db_error().'"}';
             }
    }
    else {
       echo '{"success":0,  "error":"'.$dt->db_error().'"}';
    }
  }
  $dt->close();
?>
