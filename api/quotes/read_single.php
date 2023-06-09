<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//required files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

//DB connection
$database = new Database();
$db = $database->connect();

//Create quote object
$quote = new Quote($db);

//Get ID
$quote->id = isset($_GET['id']) ? $_GET['id']: die();

//Get quote
$quote->read_single();

if((isset($quote->id) && isset($quote->quote))){
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author,
        'category'=> $quote->category
    );
    
    echo json_encode($quote_arr);
}else{
    echo json_encode(array('message' => 'No Quotes Found'));
}

?>