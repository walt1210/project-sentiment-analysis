<?php
require_once __DIR__ ."/../config.php";
require_once __DIR__ ."/SentimentAnalyzer.php";

//ADD SENTIMENT, update when the text is updated, 
//delete when review is deleted, retrieve (with positive, negative, neutral, or all)


class SentimentModel{
    private $conn;

    //constructor worker
    public function __construct() {
        $this->conn= Database::connect();
    }


    //create sentiment after creating product review
    public function add($product_review_id, $review_text) {
        $analysis = SentimentAnalyzer::analyze($review_text);
        $positive_count= $analysis["positive_count"];
        $negative_count= $analysis["negative_count"];
        $type = "";
        $percentage = 50.00;
        if($positive_count < $negative_count){
            $type = "negative";
            $percentage = ($positive_count / ($positive_count + $negative_count)) * 100; //positive percentage
        }
        elseif($positive_count > $negative_count){
            $type = "positive";
            $percentage = ($positive_count / ($positive_count + $negative_count)) * 100; //positive percentage
        }
        else{
            $type = "Neutral";
        }
        $stmt = $this->conn->prepare("INSERT INTO sentiments (product_review_id, positive_count, negative_count, `percentage`, `type`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iiids", $product_review_id, $positive_count, $negative_count, $percentage, $type);
        //$this->conn->insert_id;
        return $stmt->execute();
    }

    public function update($product_review_id, $review_text) {
        $analysis = SentimentAnalyzer::analyze($review_text);
        $positive_count= $analysis["positive_count"];
        $negative_count= $analysis["negative_count"];
        $type = "";
        $percentage = 50.00;
        if($positive_count < $negative_count){
            $type = "negative";
            $percentage = ($positive_count / ($positive_count + $negative_count)) * 100; //positive percentage
        }
        elseif($positive_count > $negative_count){
            $type = "positive";
            $percentage = ($positive_count / ($positive_count + $negative_count)) * 100; //positive percentage
        }
        else{
            $type = "neutral";
        }
        $stmt = $this->conn->prepare("UPDATE sentiments SET positive_count=?, negative_count=?, `percentage`=?, `type`=? WHERE product_review_id=?");
        $stmt->bind_param("iidsi",  $positive_count, $negative_count, $percentage, $type, $product_review_id);
        //$this->conn->insert_id;
        return $stmt->execute();
    }
    
    //delete sentiment
    public function delete($product_review_id){
        $stmt = $this->conn->prepare("DELETE FROM sentiments WHERE product_review_id = ?");
        $stmt->bind_param("s", $product_review_id); 
        return $stmt->execute();
    }

    //retrieve all sentiments
     public function getAll(){
        $result =$this->conn->query("SELECT * FROM sentiments");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>