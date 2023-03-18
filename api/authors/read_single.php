<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

//DB connection
$database = new Database();
$db = $database->connect();

// create author object
$author = new Author($db);

// get id
$author->id = isset($_GET['id']) ? $_GET['id']: die();

// Get post
$author->read_single();

if((isset($author->id) && isset($author->author))){
    $author_arr = array(
        'id'            => $author->id,
        'author'      => $author->author
    );

    print_r(json_encode($author_arr));
}else{
    print_r(json_encode(array('message' => 'author_id Not Found')));
}

?>