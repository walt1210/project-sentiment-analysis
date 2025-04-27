<?php

class SentimentAnalyzer{
    

    private static $negative_words = [];
    private static $positive_words = [];
    //private $review_text;

    // public function __construct(){
    //     $this->getLexicons();
    // }

    private static function getLexicons(){
        $positive_filetext = '../lexicons/positive-words.txt';
        $negative_filetext = '../lexicons/negative-words.txt';
        //opens file
        $file_positive = fopen($positive_filetext,'r');

        if($file_positive){
            //read file line by line
            while(($line = fgets($file_positive)) !== false){
                //store to variable each line
                self::$positive_words[] = $line;
            }
            fclose($file_positive);
        }

        $file_negative = fopen($negative_filetext,'r');

        if($file_negative){
            //read file line by line
            while(($line = fgets($file_negative)) !== false){
                //store to variable each line
                self::$negative_words[] = trim($line);
            }
            fclose($file_negative);
        }
    }


    public static function analyze($review_text){
        if(empty(self::$negative_words) && empty(self::$positive_words)){
            self::getLexicons();
        }
        $positive_count = 0;
        $negative_count = 0;
        //$positive_words = positive_words;
        $review_text = preg_replace("/[^a-zA-Z]/", "", $review_text);
        //$review_text = strtolower($review_text);
        $txt_to_analyze = explode(' ', strtolower($review_text));

        foreach($txt_to_analyze as $word){
            $word = trim($word);
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