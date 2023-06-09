<?php

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    
    //required files
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //DB connection
    $database = new Database();
    $db = $database->connect();

    //create category object
    $category = new Category($db);

    //Category read query
    $result = $category->read();

    //Get row count
    $num = $result->rowCount();

    if($num > 0) {
        $category_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $category_item = array(
            'id' => $id,
            'category' => $category
          );

          array_push($category_arr, $category_item);
        }

        echo json_encode($category_arr);

    } else {
        echo json_encode(array('message' => 'No Categories Found'));
    }

  ?>