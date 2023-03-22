<?php

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');

    //required files
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //DB connection
    $database = new Database();
    $db = $database->connect();

    // create author object
    $author = new Author($db);

    // Read DB
    $result = $author->read();

    // Get row count
    $num = $result->rowCount();

    if($num > 0) {
        $author_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $author_item = array(
            'id' => $id,
            'author' => $author
          );

          array_push($author_arr, $author_item);
        }

        echo json_encode($author_arr);

    } else {
        echo json_encode(array('message' => 'No Authors Found'));
    }

  ?>