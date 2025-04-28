<?php
require_once __DIR__ ."/../config.php";


//products, product reviews, sentiment, activity log

class ProductModel{
    private $conn;

    //constructor worker
    public function __construct() {
        $this->conn = Database::connect();
    }

    //create new product
    public function add($name, $category_id, $description, $image_url){
        $stmt = $this->conn->prepare("INSERT INTO products (`name`, category_id, `description`, image_url) VALUES (?,?,?,?)");
        $stmt->bind_param("siss", $name, $category_id, $description, $image_url);
        //$this->conn->insert_id;
        return $stmt->execute();
    }

    //retrieve all products
    public function getAll(){
        $result =$this->conn->query("SELECT * FROM products");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //update products
    public function update($id, $name, $category_id, $description, $image_url){
        $stmt = $this->conn->prepare("UPDATE products SET `name` = ?, category_id=?, `description`=?, image_url=? WHERE id = ?");
        $stmt->bind_param("sissi", $name, $category_id, $description, $image_url, $id);
        return $stmt->execute();
    }

    //delete product
    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("s", $id); 
        return $stmt->execute();
    }

}


?>