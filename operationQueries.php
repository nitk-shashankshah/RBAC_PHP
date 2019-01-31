<?php
class operationQueries {
   var $dbType ='mysql';

   public function authenticate($email, $pass){
     $sq = "";
     switch ($this->dbType) {
       case 'mysql':
         $sq = 'select organization.org_name,user_role.role_id,roles.role_name,users.user_id,users.counter,users.user_name,users.org_id,users.last_activity from users inner join user_role on users.user_id=user_role.user_id inner join organization on organization.org_id=users.org_id inner join roles on roles.role_id=user_role.role_id where users.email_addr=\''.$email.'\' and users.password=SHA1(\''.$pass.'\')';
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }
   public function insertUserRole($user_id,$role_id){
      $sq="";
      switch ($this->dbType) {
      case 'mysql':
       $sq = "insert into user_role (user_id, role_id) values('".$user_id."','".$role_id."')";
       break;
       case 'cassandra':
       break;
       default:
       break;
       }
       return $sq;
   }

   public function updateUserRole($role_id, $user_id){
      $sq="";
      switch ($this->dbType) {
      case 'mysql':
       $sq = "update user_role set role_id='".$role_id."' where user_id='".$user_id."'";
       break;
      case 'cassandra':
       break;
      default:
       break;
      }
      return $sq;
   }

   public function deleteUserRole($user_id){
      $sq="";
      switch ($this->dbType) {
      case 'mysql':
       $sq = "delete from user_role where user_id='".$user_id."'";
       break;
      case 'cassandra':
       break;
      default:
       break;
      }
      return $sq;
   }

   public function getUserRole($user_id){
      $sq="";
      switch ($this->dbType) {
      case 'mysql':
       $sq = "select * from user_role where user_id='".$user_id."'";
       break;
      case 'cassandra':
       break;
      default:
       break;
     }
     return $sq;
   }

   public function listOrgRoles($org_id){
      $sq="";
      switch ($this->dbType) {
        case 'mysql':
         $sq = "select DISTINCT(role_id),role_name from roles where org_id='".$org_id."' order by LOWER(role_name)";
         break;
        case 'cassandra':
         break;
        default:
         break;
       }
       return $sq;
   }

   public function getTenantCount($org){
   $sq="";
   switch ($this->dbType) {
     case 'mysql':
        $sq = "select count(*), organization.org_id, organization.org_name from organization LEFT OUTER JOIN users ON organization.org_id=users.org_id where organization.org_id='".$org."'";
        break;
     case 'cassandra':
        break;
     default:
        break;
    }
    return $sq;
   }

   public function getSuperTenantCount(){
   $sq="";
   switch ($this->dbType) {
     case 'mysql':
       $sq= "select count(*), organization.org_id, organization.org_name from organization LEFT OUTER JOIN users ON organization.org_id=users.org_id GROUP BY users.org_id";
       break;
     case 'cassandra':
       break;
     default:
       break;
     }
     return $sq;
   }

   public function checkUser($user){
       $sq="";
       switch ($this->dbType) {
       case 'mysql':
        $sq = "select * from users where users.email_addr='".$user."'";
        break;
       case 'cassandra':
        break;
       default:
        break;
      }
      return $sq;
   }
   public function listUsers($org_id){
      $sq="";
      switch ($this->dbType) {
        case 'mysql':
           $sq = "select users.user_id,users.user_name, users.password,users.email_addr,users.org_id,users.last_activity,users.counter,user_role.role_id from users LEFT OUTER JOIN user_role ON user_role.user_id=users.user_id where users.org_id='".$org_id."' order by LOWER(users.user_name)";
           break;
          case 'cassandra':
           break;
          default:
           break;
         }
         return $sq;
   }

   public function listUserPermissions($user_id){
      $sq="";
      switch ($this->dbType) {
        case 'mysql':
         $sq = "select t1.user_id,t2.role_name, t5.feature,t4.access_desc from user_role as t1 inner join roles as t2 on t1.role_id=t2.role_id inner join accessTypes as t4 on t4.access_id=t2.access_id inner join features as t5 on t5.feature_id=t2.feature_id where t1.user_id='".$user_id."' GROUP BY t5.feature";
         break;
        case 'cassandra':
         break;
        default:
         break;
       }
       return $sq;
   }

   public function listOrgPermissions($org_id){
      $sq="";
      switch ($this->dbType) {
        case 'mysql':
         $sq = "select organization.org_id, features.feature,organization.org_name from organization inner join org_feature ON organization.org_id=org_feature.org_id inner join features on features.feature_id=org_feature.feature_id where organization.org_id='".$org_id."'";
         break;
        case 'cassandra':
         break;
        default:
         break;
       }
       return $sq;
   }

   public function getRoleDetails($role_id, $org_id){
    $sq="";
    switch ($this->dbType) {
      case 'mysql':
       $sq = "select roles.role_name,roles.role_id,features.feature,accessTypes.access_desc from roles INNER JOIN features on features.feature_id=roles.feature_id INNER JOIN accessTypes on accessTypes.access_id=roles.access_id where role_id='".$role_id."' and org_id='".$org_id."'";
       break;
      case 'cassandra':
       break;
      default:
       break;
     }
     return $sq;
   }

  /* public function getRoleWithFeature($role_id,$feature){
    $sq="";
    switch ($this->dbType) {
      case 'mysql':
       $sq = "select * from roles where role_id='".$role_id."' and feature_id=(select feature_id from features where feature='".$feature."')";
       break;
      case 'cassandra':
       break;
      default:
       break;
     }
     return $sq;
   }*/


   public function listFeatures(){
      $sq="";
      switch ($this->dbType) {
        case 'mysql':
         $sq = "select * from features";
         break;
        case 'cassandra':
         break;
        default:
         break;
      }
      return $sq;
   }
   public function listOrganizations(){
      $sq="";
      switch ($this->dbType) {
        case 'mysql':
         $sq = "select organization.org_name,users.email_addr,organization.admin_id,organization.org_id, features.feature from organization LEFT OUTER JOIN org_feature ON organization.org_id=org_feature.org_id LEFT OUTER JOIN features ON features.feature_id=org_feature.feature_id LEFT OUTER JOIN users on users.user_id=organization.admin_id order by LOWER(organization.org_name)";
         break;
        case 'cassandra':
         break;
        default:
         break;
      }
      return $sq;
   }

   public function listAccessTypes(){
      $sq="";
      switch ($this->dbType) {
        case 'mysql':
         $sq = "select * from accessTypes";
         break;
        case 'cassandra':
         break;
        default:
         break;
      }
      return $sq;
   }

   public function getUser($email){
    $sq="";
    switch ($this->dbType) {
      case 'mysql':
        $sq = 'SELECT user_id, email_addr FROM users WHERE email_addr =\''.$email.'\'';
        break;
      case 'cassandra':
        break;
      default:
        break;
    }
    return $sq;
   }

   public function getOrgByName($name){
      $sq="";
      switch ($this->dbType) {
       case 'mysql':
        $sq = "select org_id from organization where org_name='".$name."'";
        break;
       case 'cassandra':
        break;
       default:
        break;
      }
      return $sq;
   }

   public function createUser($user_name,$email_id,$org_id){
      $sq="";
      switch ($this->dbType) {
       case 'mysql':
        $sq = "insert into users (user_id, user_name, password, email_addr, org_id, last_activity, counter) values (uuid(),'".$user_name."', SHA1('ruckus'),'".$email_id."','".$org_id."',now(),0)";
        break;
       case 'cassandra':
        break;
       default:
        break;
      }
      return $sq;
   }

   public function listOrgGroups($org_id){
     $sq="";
     switch ($this->dbType) {
      case 'mysql':
       $sq = "select * from groups where org_id ='".$org_id."'";
       break;
      case 'cassandra':
       break;
      default:
       break;
      }
      return $sq;
   }
   public function deleteOrgGroup($org_id,$group){
     $sq="";
     switch ($this->dbType) {
      case 'mysql':
       $sq = "delete from groups where org_id ='".$org_id."' and groupName='".$group."'";
       break;
      case 'cassandra':
       break;
      default:
       break;
      }
      return $sq;
   }
   public function insertOrgGroups($org_id,$group){
     $sq="";
     switch ($this->dbType) {
      case 'mysql':
       $sq = "insert into groups (org_id,groupName) values ('".$org_id."','".$group."')";
       break;
      case 'cassandra':
       break;
      default:
       break;
      }
      return $sq;
   }

   public function getFeature($feature){
     $sq="";
     switch ($this->dbType) {
      case 'mysql':
       $sq = "select * from features where feature in ('".$feature."')";
       break;
      case 'cassandra':
       break;
      default:
       break;
      }
      return $sq;
   }

   public function insertFeature($org_id,$feature){
     $sq="";
     switch ($this->dbType) {
      case 'mysql':
       $sq = "insert into org_feature (org_id, feature_id) values ('".$org_id."',(select feature_id from features where feature='".$feature."'))";
       break;
      case 'cassandra':
       break;
      default:
       break;
      }
      return $sq;
   }

   public function addOrganization($org_name){
     $sq="";
     switch ($this->dbType) {
      case 'mysql':
       $sq = "insert into organization (org_id, org_name, admin_id) values(uuid(),'".$org_name."',null)";
       break;
      case 'cassandra':
       break;
      default:
       break;
     }
     return $sq;
   }

   public function getOrganization($org_name){
    $sq="";
    switch ($this->dbType) {
      case 'mysql':
        $sq = "select org_id from organization where org_name='".$org_name."'";
        break;
      case 'cassandra':
        break;
      default:
        break;
    }
    return $sq;
   }

   public function updateAdmin($admin_id, $org_id) {
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
         $sq = "update organization set admin_id=(select user_id from users where email_addr='".$admin_id."') where org_id ='".$org_id."'";
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }

   public function deleteOrgFeature($id) {
        $sq="";
        switch ($this->dbType) {
          case 'mysql':
            $sq = "delete from org_feature where org_id in ('".$id."')";
            break;
          case 'cassandra':
            break;
          default:
            break;
        }
        return $sq;
   }


   public function updateRoleName($role_name, $role_id) {
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
         $sq = "update roles set role_name='".$role_name."' where role_id='".$role_id."'";
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }

   public function updateUserEmail($email_id, $user_id) {
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
          $sq = "update users set email_addr='".$email_id."' where user_id='".$user_id."'";
          break;
        case 'cassandra':
          break;
        default:
          break;
      }
      return $sq;
  }

  /* public function updateRole($accessType, $feature, $role_id) {
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
         $sq = "update roles set access_id=(select access_id from accessTypes where access_desc='".$accessType."') where role_id='".$role_id."' and feature_id=(select feature_id from features where feature='".$feature."')";
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }*/
   public function createRole($org_id, $roleName, $feature, $access, $roleId) {
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
         $sq = "insert into roles (role_id,org_id,role_name,feature_id,access_id) values (".$roleId.",'".$org_id."','".$roleName."',(select feature_id from features where feature='".$feature."'),(select access_id from accessTypes where access_desc='".$access."'))";
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }

   public function deleteGroups($org_id) {
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
         $sq = 'DELETE from groups where org_id=\''.$org_id.'\'';
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }

   public function deleteOrganization($org_id) {
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
         $sq = 'DELETE t1, t2, t3, t4, t5 from organization as t1 left outer join users as t2 on t1.org_id=t2.org_id inner join org_feature as t3 on t3.org_id=t2.org_id inner join roles as t4 on t4.org_id=t3.org_id left outer join user_role as t5 on t5.role_id=t4.role_id where t1.org_id =\''.$org_id.'\'';
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }

   public function checkRoleAssigned($role,$orgId){
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
         $sq = "select user_role.role_id, user_role.user_id FROM roles inner join user_role on roles.role_id=user_role.role_id where roles.org_id='".$orgId."' and roles.role_id='".$role."' GROUP BY user_role.user_id";
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }

   public function deleteRole($role, $orgId) {
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
         $sq = "DELETE t1, t2 FROM roles as t1 LEFT OUTER JOIN user_role as t2 on t1.role_id = t2.role_id WHERE t1.role_id= '".$role."' and t1.org_id='".$orgId."'";
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }

   public function deleteUser($user_id) {
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
         $sq = "delete t1,t2 from users as t1 left outer join user_role as t2 on t1.user_id=t2.user_id where t1.user_id = '".$user_id."'";
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }

   public function deleteRolesEntriesWithFeature($org_id, $feature) {
     $sq="";
     switch ($this->dbType) {
      case 'mysql':
        $sq = "DELETE FROM roles where org_id='".$org_id."' and feature_id IN (select feature_id from features where feature='".$feature."')";
        break;
      case 'cassandra':
        break;
      default:
        break;
      }
      return $sq;
   }

   public function deleteRoleEntry($role, $org_id, $feature) {
     $sq="";
     switch ($this->dbType) {
      case 'mysql':
        $sq = "DELETE FROM roles where role_id='".$role."' and feature_id IN (select feature_id from features where feature='".$feature."')";
        break;
      case 'cassandra':
        break;
      default:
        break;
      }
      return $sq;
   }

   public function selectRole($org_id, $roleName, $feature_names){
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
         $sq = "select role_id from roles where org_id='".$org_id."' and role_name='".$roleName."' and feature_id=(select feature_id from features where feature='".$feature_names[0]."')";
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }

   public function updateActivity($counter, $email){
     $sq="";
     switch ($this->dbType) {
       case 'mysql':
         $sq = 'update users set last_activity=now(), counter='.$counter.' where users.email_addr=\''.$email.'\'';
         break;
       case 'cassandra':
         break;
       default:
         break;
     }
     return $sq;
   }

   public function __construct() {
   }
}
?>
