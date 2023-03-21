<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    //include_once '../../models/Author.php';
    //include_once '../../models/Category.php';
  
    //DB connection
    $database = new Database();
    $db = $database->connect();

    //Quote object
    $quote = new Quote($db);

    //get input
    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)){ 
        echo json_encode(array('message'=> 'Missing Required Parameters'));
        exit();
    }

    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;


    if(!isset($quote->author_id) && isset($quote->category_id)){
        echo json_encode(array('message' => 'author_id Not Found'));
        exit();
    }

    if(isset($quote->author_id) && !isset($quote->category_id)){
        echo json_encode(array('message' => 'category_id Not Found'));
        exit();
    }

    if($quote->create()){
        echo json_encode(array("id"=> $db->lastInsertId(), "quote"=>$quote->quote, "author_id"=>$quote->author_id, "category_id"=>$quote->category_id));
    }






?>

