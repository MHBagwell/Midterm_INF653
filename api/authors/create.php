<?php
    //Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //database connection
    $database = new Database();
    $db = $database->connect();

    //create author object
    $author = new Author($db);

    //get input
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->author)) {

        $author->author = $data->author;
        $author->create();
    
        echo json_encode(array('id'=>$db->lastInsertId(), 'author'=>$author->author));
    
    } else {
        echo json_encode(array('message' => 'Missing Required Parameters'));
    }

?> 