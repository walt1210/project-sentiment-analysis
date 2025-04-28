<?php
require_once __DIR__ ."/../config.php";

class UserModel{
    private $conn;

    //constructor worker
    public function __construct() {
        $this->conn = Database::connect();
    }

    //create new user
    public function add($email, $first_name, $last_name, $password_, $role_id="1"){
        $stmt = $this->conn->prepare("INSERT INTO users (email, first_name, last_name, password_, role_id) VALUES (?,?,?,?,?)");
        $stmt->bind_param("ssssi", $email, $first_name, $last_name, $password_, $role_id);
        return $stmt->execute();
    }

    //retrieve all users
    public function getAll(){
        $result =$this->conn->query("SELECT * FROM users");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //get username row
    public function getbyEmail($email){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
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

    //update password
    public function changePassword($email, $password_){
        $stmt = $this->conn->prepare("UPDATE users SET password_ =  ? WHERE email = ?");
        $stmt->bind_param("ss", $password_, $email);
        return $stmt->execute();
    }

    //update infos
    public function update($email, $first_name, $last_name, $role_id=1){
        $stmt = $this->conn->prepare("UPDATE users SET first_name =  ?, last_name=?, role_id=? WHERE email = ?");
        $stmt->bind_param("ssis", $first_name, $last_name, $role_id, $email);
        return $stmt->execute();
    }


    public function delete($email){
        $stmt = $this->conn->prepare("DELETE FROM users WHERE email = ?");
        $stmt->bind_param("s", $email); 
        return $stmt->execute();
    }

}


?>