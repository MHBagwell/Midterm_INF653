<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
  
    //DB connection
    $database = new Database();
    $db = $database->connect();
  
    //create quote object
    $quote = new Quote($db);

    // get input
    $data = json_decode(file_get_contents("php://input"));

    $quote->id = $data->id;

    //Delete
    if($quote->delete()){
        echo json_encode(array('id'=>$quote->id));
    }else {
        echo json_encode(array('message'=>'No Quotes Found'));
    }



?>