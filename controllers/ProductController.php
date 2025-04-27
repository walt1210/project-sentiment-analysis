<?php
//include class file loc
require_once __DIR__ ."/../config.php";
require_once __DIR__ ."/../models/ProductsModel.php";


class ProductController{
    //instantiate models
    private $ProductModel;

    public function __construct(){
        $this->ProductModel = new ProductModel();
    }

    //retrieve all
    public function index(){
        $products = $this->ProductModel->getAll();
        return $products;
        //echo json_encode($products);
        //for view
    }

    public function add(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $name = $_POST["name"];
            $category_id = $_POST["category_id"];
            $description = $_POST["description"];
            $image_url = $_POST["image"];

            if(empty($name) || empty($category_id) || empty($description) || empty($image_url)){
                return ["success" => false, "message" => "Please fill up all empty fields!"] ;
                //echo json_encode(["success" => false, "message" => "Please fill up all empty fields!"]);
            }
            else{
                $success = $this->ProductModel->add($name, $category_id, $description, $image_url);
                $msg = ($success) ? "Added succesfully!" : "Failed to add";
                return ["success"=> $success,"message"=> $msg];
                //echo json_encode(["success"=> $success,"message"=> "Added succesfully!"]);
            }
        }
    }

    public function edit(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $id = $_POST["id"];
            $name = $_POST["name"];
            $category_id = $_POST["category_id"];
            $description = $_POST["description"];
            $image_url = $_POST["image"];

            if(empty($name) || empty($category_id) || empty($description) || empty($image_url) || empty(($id))){
                return ["success" => false, "message" => "Please fill up all empty fields!"] ;
                //echo json_encode(["success" => false, "message" => "Please fill up all empty fields!"]);
            }
            else{
                $success = $this->ProductModel->update($id , $name, $category_id, $description, $image_url);
                $msg = ($success) ? "Updated succesfully!" : "Failed to update";
                return ["success"=> $success,"message"=> $msg];
                // echo json_encode(["success"=> $success,"message"=> "Updated succesfully!"]);
            }
        }
    }

    public function delete(){
        $id = $_GET["id"];
        $success = $this->ProductModel->delete($id);
        $msg = ($success) ? "Deleted succesfully!" : "Failed to deleted";
        return ["success"=> $success,"message"=> $msg];
        //echo json_encode(["success"=> $success,"message"=> $msg]);
    }

}
?>