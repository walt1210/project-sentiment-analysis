<?php

class Database{
    private static $conn;
    public static function connect(){
        if(!self::$conn){
            self::$conn = new mysqli("localhost","root","","sentiment_analysis");
            if(self::$conn->connect_error){
                die("Connection failed: ".self::$conn->connect_error);
            }
        }
        return self::$conn;
    }

}

// $host = "localhost";
// $username = "root";
// $password = ""; 
// $database = "sentiment_analysis";

// $conn = new mysqli($host, $username, $password, $database);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
?>