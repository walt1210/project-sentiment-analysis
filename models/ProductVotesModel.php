<?php

require_once __DIR__ ."/../config.php";

class ProductVoteModel{
    private $conn;

    //constructor worker
    public function __construct() {
        $this->conn = Database::connect();
    }

    public function add($user_id, $product_id, $vote){
        $stmt = $this->conn->prepare("INSERT INTO product_votes (user_id, product_id, vote) VALUES (?,?,?)");
        $stmt->bind_param("iis",$user_id, $product_id, $vote);
        return $stmt->execute();
    }

    public function update($user_id, $product_id, $vote){
        $stmt = $this->conn->prepare("UPDATE product_votes SET vote=? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("sii", $vote, $user_id, $product_id);
        return $stmt->execute();
    }

    public function delete($user_id, $product_id){
        $stmt = $this->conn->prepare("DELETE FROM product_votes WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id); 
        return $stmt->execute();
    }

    public function getAll(){
        $result =$this->conn->query("SELECT * FROM product_votes");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>