<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//required files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';
include_once '../../functions/Function.php';

//Db connection
$database = new Database();
$db = $database->connect();

//create quote object
$quote = new Quote($db);

//Get input
$data = json_decode(file_get_contents("php://input"));

if(isset($data->id) && isset($data->quote) && isset($data->author_id) && isset($data->category_id)){

    //set data
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    if(!isValid($data->author_id, new Author($db))){
        echo json_encode(array('message'=> 'author_id Not Found'));
    }else if(!isValid($data->category_id, new Category($db))){
        echo json_encode(array('message'=> 'category_id Not Found'));
    }else{
        $quote->update();
        echo json_encode(array('id'=>$quote->id,'quote'=>$quote->quote,'author_id'=>$quote->author_id,'category_id'=>$quote->category_id));
    }

}else if(!isset($data->quote)){
    echo json_encode(array('message' => 'No Quotes Found'));
}else{
    echo json_encode(array('message' => 'Missing Required Parameters'));
}

?>
