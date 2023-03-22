<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    //DB connection
    $database = new Database();
    $db = $database->connect();

    // create quote object
    $quote = new Quote($db);

    $result = $quote->read();

    //get row count
    $num = $result->rowCount();

    //Checking for quotes
    if($num > 0){
        $quotes_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );

            array_push($quotes_arr, $quote_item);
        }

        echo json_encode($quotes_arr);
    } else {
        echo json_encode(array('message' => 'No Quotes Found'));
    }
    
?>
