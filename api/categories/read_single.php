<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//create database object
$database = new Database();
$db = $database->connect();

// create category object
$category = new Category($db);

// get id
$category->id = isset($_GET['id']) ? $_GET['id']: die();

// Get post
$category->read_single();

if((isset($category->id) && isset($category->category))){
    $category_arr = array(
        'id'            => $category->id,
        'category'      => $category->category
    );
    
    print_r(json_encode($category_arr));
}else{
    print_r(json_encode(array('message' => 'category_id Not Found')));
}

?>