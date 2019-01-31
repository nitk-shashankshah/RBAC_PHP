<?php
class db {
   var $dbname = 'Ruckus_interface';
   var $servername = 'localhost';
   var $username = 'root';
   var $password = '';
   var $dbType ='mysql';
   var $conn;

   public function connect(){
     switch ($this->dbType) {
       case 'mysql':
          $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
          if ($this->conn->connect_error) {
           die("Connection failed: " . $this->conn->connect_error);
         }
         break;
       case 'cassandra':
         break;

       default:
         break;
     }
   }

   public function __construct() {
   }

   public function db_error(){
     $error="";
     switch ($this->dbType) {
       case 'mysql':
          $error =  mysqli_error($this->conn);
       case 'cassandra':
          break;
       default:
          break;
     }
     return $error;
   }

   public function affected(){
     $rows=-1;
     switch ($this->dbType) {
        case 'mysql':
           $rows = mysqli_affected_rows($this->conn);
           break;
        case 'cassandra':
           break;
        default:
           break;
     }
     return $rows;
   }

   public function getRows($result) {
      $rows=-1;
      switch ($this->dbType) {
            case 'mysql':
               $rows = mysqli_num_rows($result);
               break;
            case 'cassandra':
               //$rows = $result->count();
               break;
            default:
               break;
      }
      return $rows;
   }

   public function query($q) {
       switch ($this->dbType) {
          case 'mysql':
             $result = $this->conn->query($q);
             break;
          case 'cassandra':
             break;
          default:
             break;
       }
       return $result;
   }

   public function close() {
     $this->conn->close();
   }
}
?>
