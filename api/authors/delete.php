<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    //required files
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //database connection
    $database = new Database();
    $db = $database->connect();

    //create author object
    $author = new Author($db);

    //get input
    $data = json_decode(file_get_contents("php://input"));

    if(isset($data->id)) {

        $author->id = $data->id;
        $author->delete();
    
        echo json_encode(array('id'=>$author->id));
    
    } else {
        echo json_encode(array('message' => 'Missing Required Parameters'));
    }

?> 