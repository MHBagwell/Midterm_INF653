<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    //required files
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //DB connection
    $database = new Database();
    $db = $database->connect();

    //create category object
    $category = new Category($db);

    //get input
    $data = json_decode(file_get_contents("php://input"));

    //Create
    if(isset($data->category)) {

      $category->category = $data->category;
      $category->create();
    
      echo json_encode(array("id"=>$db->lastInsertId(), "category"=>$category->category));
    
    } else {
      echo json_encode(array('message' => 'Missing Required Parameters'));
    }

?> 