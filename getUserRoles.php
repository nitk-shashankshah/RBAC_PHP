<?php
  header('Access-Control-Allow-Origin: *');
  require_once 'db.php';
  $dt = new db();
  $dt->connect();

  if(isset($_GET["orgId"])) {
    $org_id = $_GET["orgId"];
    $sql = "select DISTINCT t3.name from org_role as t1 INNER JOIN role_perm as t2 on t1.role_id=t2.role_id INNER JOIN accessRoles as t3 on t3.perm_id=t2.perm_id where t1.org_id=".$org_id." ORDER by t3.name";
    $result = $dt->query($sql);
    $res="[";
    if ($dt->getRows() > 0) {
        foreach ($result as $row) {
            $res = $res. "\"".$row["name"]."\",";
        }
    }
    $res = rtrim($res,',');
    $res=$res."]";
    echo $res;
  }
  $dt->close();
?>
