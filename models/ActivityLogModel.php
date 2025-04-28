<?php
require_once __DIR__ ."/../config.php";

class ActivityLogModel{
    private $conn;

    //constructor worker
    public function __construct() {
        $this->conn = Database::connect();
    }

    //create new log for user
    public function add($user_id, $log_action){
        $log_action = (in_array($log_action, ["login", "logout"])) ? $log_action :"login";
        $stmt = $this->conn->prepare("INSERT INTO activity_logs (user_id, log_action) VALUES (?,?)");
        $stmt->bind_param("is", $user_id,  $log_action);
        return $stmt->execute();
    }

    //retrieve all users
    public function getAll(){
        $result =$this->conn->query("SELECT * FROM activity_logs");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //get last login of user by id
    public function getLastLogin($user_id){
        $stmt = $this->conn->prepare("SELECT log_time FROM activity_logs WHERE user_id = ? ORDER BY log_time DESC LIMIT 1");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        //return $stmt->get_result()->fetch_assoc();
        if($result->num_rows == 1){
            return $result->fetch_assoc();
        }
        else{
            return null;
        }
        
    }

}


?>