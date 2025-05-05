<?php
require_once __DIR__ ."/../config.php";

class SentimentAnalyzer{    

    public static $negative_words = [];
    public static $positive_words = [];
    //private static $conn;
    private static $stmt;


    //load from file to database
    //get words from database to here

    //add to database function
    public static function addWords($word, $type){
        $conn = Database::connect();
        if(in_array($type, ['positive', 'negative'])){
            $type = $type.'_words';
            $stmt = $conn->prepare("INSERT INTO $type (words) VALUES (?)");
            $stmt->bind_param("s", $word);
            $conn->close();
            return $stmt->execute();
        }
        //$conn->close();
        return false;
    }

    //gets words from database 
    public static function getLexiconsFromDatabase(){
        $success_positive = false;
        $success_negative = false;
        $conn = Database::connect();
        $result = $conn->query("SELECT * FROM positive_words");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                self::$positive_words[] = $row["words"];
            }
            $success_positive = true;
        }

        $result = $conn->query("SELECT * FROM negative_words");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                self::$negative_words[] = $row["words"];
            }
            $success_negative = true;
        }

        return $success_positive && $success_negative;
    }

    //gets words from text file and load to database (if database is empty)
    private static function getLexiconsFromFile(){
        $conn = Database::connect();
        $positive_filetext = __DIR__.'/../lexicons/positive-words.txt';
        $negative_filetext = __DIR__.'/../lexicons/negative-words.txt';
        //opens file
        $file_positive = fopen($positive_filetext,'r');

        if($file_positive){
            $stmt = $conn->prepare("INSERT INTO positive_words (words) VALUES (?)");
            //read file line by line
            while(($line = fgets($file_positive)) !== false){
                //store to variable each line
                $line = trim($line);
                $stmt->bind_param("s", $line);
                $stmt->execute();
            }
            $stmt->close();
            fclose($file_positive);
        }

        $file_negative = fopen($negative_filetext,'r');

        if($file_negative){
            $stmt = $conn->prepare("INSERT INTO negative_words (words) VALUES (?)");
            //read file line by line
            while(($line = fgets($file_negative)) !== false){
                //store to variable each line
                $line = trim($line);
                $stmt->bind_param("s", $line);
                $stmt->execute();
            }
            $stmt->close();
            fclose($file_negative);
        }
    }

    public static function analyze($review_text){
        if(empty(self::$negative_words) || empty(self::$positive_words)){
            if(!self::getLexiconsFromDatabase()){
                self::getLexiconsFromFile();
                self::getLexiconsFromDatabase();
            }
        }
        self::$negative_words = array_unique(self::$negative_words);
        self::$positive_words = array_unique(self::$positive_words);
        $positive_count = 0;
        $negative_count = 0;
        //$positive_words = positive_words;
        $review_text = preg_replace("/[^a-zA-Z]/", " ", $review_text);
        $review_text = strtolower($review_text);
        $txt_to_analyze = explode(' ', $review_text);

        foreach($txt_to_analyze as $word){
            if(in_array($word, self::$positive_words)){
                $positive_count++;
            }
            if(in_array($word, self::$negative_words)){
                $negative_count++;
            }
        }
        return ["positive_count" => $positive_count,"negative_count"=> $negative_count];

    }

}

    //algorithm for analyzing review text
    ////private function analyze() {
        //read files
        //store in var postivelist negativelist
        //check each (splitted) word in review text compare with positive and negative
        //counter: positive_count, negative_count
    ////}

?>