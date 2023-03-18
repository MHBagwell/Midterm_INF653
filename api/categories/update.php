<?php
    //Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //database connection
    $database = new Database();
    $db = $database->connect();

    //create category object
    $category = new Category($db);

    //get input
    $data = json_decode(file_get_contents("php://input"));

    // Update
  if(isset($data->category)) {

    $category->id = $data->id;
    $category->category = $data->category;
    $category->update();
    
    echo json_encode(array('id'=>$category->id, 'category'=>$category->category));
    
  } else {
    echo json_encode(array('message' => 'Missing Required Parameters'));
}

?> 
 