<?php
require_once __DIR__ ."/../config.php";
require_once __DIR__ ."/SentimentModel.php";

//sentiment, activity log

//add, delete, update, retrieve

class ProductReviewModel{
    private $conn;
    private $SentimentModel;

    //constructor worker
    public function __construct() {
        $this->conn= Database::connect();
        $this->SentimentModel = new SentimentModel();
    }

    //create new product review
    public function add($user_id, $product_id, $rating, $review_text){
        $stmt = $this->conn->prepare("INSERT INTO product_review_comments (user_id, product_id, rating, review_text) VALUES (?,?,?,?)");
        $stmt->bind_param("iiis",$user_id, $product_id, $rating, $review_text);
        return ($stmt->execute() && $this->SentimentModel->add($this->conn->insert_id, $review_text));
    }

    //retrieve all product review
    public function getAll(){
        $result =$this->conn->query("SELECT * FROM product_review_comments");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //get all products including sentiments (default have no filter)
    public function getAllWithSentiment($product_id = "", $sentiment_type = ""){
       
        //if filter by product
        if ($product_id != "") $product_id =  "products.id = '$product_id'";
        
        //if filter by sentiment type
        $filter_list = ["positive", "negative", "neutral"];
        $sentiment_type = ($sentiment_type != "" && in_array(strtolower(trim($sentiment_type)), $filter_list) ) ? "sentiments.type = '$sentiment_type'" : "";
        $filter = "";
        //if has product and review filter
        if($product_id != "" && $sentiment_type != ""){
            $filter = "WHERE $product_id AND $sentiment_type";
        }
        //if filter has product, no review or if no product and has review
        elseif($product_id != "" ^ $sentiment_type!=""){
            $filter = "WHERE $product_id $sentiment_type";
        }

        $sql = "SELECT
                products.name AS 'product_name',
                categories.name AS 'category_name',
                users.email,
                product_review_comments.rating,
                product_review_comments.review_text,
                sentiments.percentage,
                sentiments.type
            FROM product_review_comments
            LEFT JOIN products ON product_review_comments.id = products.id
            LEFT JOIN categories ON products.category_id = categories.id
            LEFT JOIN sentiments ON product_review_comments.id = sentiments.product_review_id
            LEFT JOIN users ON product_review_comments.user_id = users.id
            $filter
            ";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //get product review row
    public function getByIds($user_id, $product_id){
        $stmt = $this->conn->prepare("SELECT * FROM product_review_comments WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
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

    //update product review
    public function update($id, $user_id, $product_id, $rating, $review_text){
        $stmt = $this->conn->prepare("UPDATE product_review_comments SET rating=?, review_text=? WHERE user_id=? AND product_id=? AND id=?");
        $stmt->bind_param("isiii", $rating, $review_text, $user_id, $product_id, $id);
        $success = $stmt->execute();
        if($success && ($stmt->affected_rows==1)){
            //$SentimentModel = new Sentiment();
            return $success && $this->SentimentModel->update($id, $review_text);;
        }
        else{
            return false;
        }
    }

    //delete product review
    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM product_review_comments WHERE id = ?");
        $stmt->bind_param("s", $id); 
        //$success = $stmt->execute();
        //$SentimentModel = new Sentiment(); 
        return ($stmt->execute() && $this->SentimentModel->delete($id));
    }


    //making csv file
    public function getCSV(){
        $data = $this->getAllWithSentiment();
        $csv_file = "sentiments_data.csv";

        $file = fopen($csv_file,"w");

        fputcsv( $file, array_keys($data[0]));

        foreach($data as $row){
            fputcsv($file, $row);
        }

        fclose($file);
    }

}


?>