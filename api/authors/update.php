<?php
    //Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');
    
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //database connection
    $database = new Database();
    $db = $database->connect();

    //create author object
    $author = new Author($db);

    //get input
    $data = json_decode(file_get_contents("php://input"));

    // Update
    if(isset($data->author)) {

      $author->id = $data->id;
      $author->author = $data->author;
      $author->update();
    
      echo json_encode(array('id'=>$author->id, 'author'=>$author->author));
    
    } else {
      echo json_encode(array('message' => 'Missing Required Parameters'));
    }

?> 