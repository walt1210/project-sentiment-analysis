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
    public function add($user_id, $product_id, $rating, $review_text): bool{
        // Sanitize review_text to prevent malicious content
        $review_text = htmlspecialchars($review_text, ENT_QUOTES, 'UTF-8');

        $stmt = $this->conn->prepare("INSERT INTO product_review_comments (user_id, product_id, rating, review_text) VALUES (?,?,?,?)");
        $stmt->bind_param("iiis", $user_id, $product_id, $rating, $review_text);
        return ($stmt->execute() && $this->SentimentModel->add($this->conn->insert_id, $review_text));
    }

    //retrieve all product review
    public function getAll(){
        $result =$this->conn->query("SELECT * FROM product_review_comments");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    //get all products including sentiments (default have no filter)
    public function getAllWithSentiment($product_id = "", $sentiment_type = ""){

        $conditions = [];

        // Validate and add product filter
        if (!empty($product_id)) {
            $conditions[] = "products.id = '" . addslashes($product_id) . "'";
        }
        
        // Validate and add sentiment type filter
        $filter_list = ["positive", "negative", "neutral"];
        $sentiment_type = strtolower(trim($sentiment_type));
        if (in_array($sentiment_type, $filter_list)) {
            $conditions[] = "sentiments.type = '" . addslashes($sentiment_type) . "'";
        }
        
        // Build the WHERE clause if there are conditions
        $filter = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
        
        $sql = "SELECT
            products.name AS 'product_name',
            categories.name AS 'category_name',
            users.email,
            product_review_comments.rating,
            product_review_comments.review_text,
            sentiments.percentage,
            sentiments.type

            FROM product_review_comments
            LEFT JOIN sentiments ON product_review_comments.id = sentiments.product_review_id
            LEFT JOIN products ON product_review_comments.product_id = products.id
            LEFT JOIN categories ON products.category_id = categories.id
            LEFT JOIN users ON product_review_comments.user_id = users.id
            $filter
            ";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //get product review row
    public function getByIds($product_id = "", $user_id = ""){
        $conditions = [];
        //if filter by user
        if (!empty($user_id)) {
            $conditions[] = "user_id = '" . addslashes($user_id) . "'";
        }
        if (!empty($product_id)) {
            $conditions[] = "product_id = '" . addslashes($product_id) . "'";
        }   
        
        $filter = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";


        $sql = "SELECT product_review_comments.*, 
            products.name AS product_name, 
            categories.name AS category_name, 
            sentiments.type
            FROM product_review_comments
            LEFT JOIN products ON product_review_comments.product_id = products.id
            LEFT JOIN categories ON products.category_id = categories.id
            LEFT JOIN sentiments ON product_review_comments.id = sentiments.product_review_id $filter" ;

        //return $stmt->get_result()->fetch_assoc();
        $result = $this->conn->query( $sql );
        return $result->fetch_all(MYSQLI_ASSOC );
      
        
    }

    public function getOneByID($id){
        $sql = "SELECT product_review_comments.*, products.name AS 'product_name'
                FROM product_review_comments
                LEFT JOIN products ON product_review_comments.product_id = products.id
                WHERE product_review_comments.id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            return $result->fetch_assoc();
        }
        else{
            return null;
        }
        
    }

    //update product review
    public function update($id, $rating, $review_text){
        $success = false;

        $stmt = $this->conn->prepare("UPDATE product_review_comments SET rating=?, review_text=? WHERE id=?");
        $stmt->bind_param("isi", $rating, $review_text, $id);
        $success_upd = $stmt->execute();

        $is_row_updated = $success_upd && ($stmt->affected_rows == 1);

        if ($is_row_updated) {
            $sentiment_updated = $this->SentimentModel->update($id, $review_text);
            $success = $sentiment_updated;
        }
        return $success;
    }

    //delete product review
    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM product_review_comments WHERE id = ?");
        $stmt->bind_param("i", $id); 
        //$success = $stmt->execute();
        //$SentimentModel = new Sentiment(); 
        return ($this->SentimentModel->delete($id) && $stmt->execute());
    }

    //making csv file
    public function getCSV(){
        $data = $this->getAllWithSentiment();
        $csv_file = "sentiments_data.csv";

        if (empty($data)) {
            throw new Exception("No data to export.");
        }

        $file = fopen($csv_file,"w");

        fputcsv( $file, array_keys($data[0]));

        foreach($data as $row){
            fputcsv($file, $row);
        }

        fclose($file);

        header('Content-Description: File Transfer');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . basename($csv_file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($csv_file));
        readfile($csv_file);
    }

    public function getProductsWithTotalSentiment(){

    $sql = "SELECT 
        products.name AS product,
        (SUM(sentiments.type = 'positive') * 100 / COUNT(*)) AS positive,
        (SUM(sentiments.type = 'neutral') * 100 / COUNT(*)) AS neutral,
        (SUM(sentiments.type = 'negative') * 100 / COUNT(*)) AS negative
      FROM product_review_comments
      LEFT JOIN products ON product_review_comments.product_id = products.id
      LEFT JOIN sentiments ON product_review_comments.id = sentiments.product_review_id
      GROUP BY products.id;";
        $result =$this->conn->query( $sql );
        return $result->fetch_all(MYSQLI_ASSOC );

    }

    public function getTotalReviewsSentimentPercentage(){
        $sql = "SELECT type,
                COUNT(*) AS total_reviews,
                ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM sentiments), 2) AS percentage
            FROM sentiments
            GROUP BY type;";
        $result =$this->conn->query( $sql );
        return $result->fetch_all(MYSQLI_ASSOC );

        

    }
    

}


?>