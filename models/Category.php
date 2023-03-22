<?php

class Category {
    //Variables
    private $conn;
    private $table = 'categories';

    //Category Properties
    public $id;
    public $category;

    //Constructor with DB
    public function __construct ($db) {
        $this->conn = $db;
    }

    //Read function
    public function read(){
        //create query
        $query = "SELECT
        id, 
        category
        FROM
        " .$this->table. "
        ORDER BY
        id";

        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        //Execute query
        $stmt->execute();

        return $stmt;
    }

    //Read single function
    public function read_single(){

        //create query
        $query = "SELECT
        id,
        category
        FROM
        " .$this->table. "
        WHERE 
        id = ?
        LIMIT 1 OFFSET 0";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(isset($row['id'])&& isset($row['category'])){
            $this->id = $row['id'];
            $this->category = $row['category'];
            return true;
        }else{
            return false;
        }
    }

    //create category
    public function create(){

        //create query
        $query = "INSERT INTO " .$this->table. " (category) 
        VALUES (:category)";

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        //Bind data
        $stmt->bindParam(':category', $this->category);

        //execute query
        if($stmt->execute()) {
            return true;
        }else{
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    //Update function
    public function update(){

        //create query
        $query = "UPDATE " .$this->table. " 
        SET category = :category
        WHERE id = :id";

        //prepare statment
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->category = htmlspecialchars(strip_tags($this->category));

        //Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':category', $this->category);

        //execute query
        if($stmt->execute()){
            return true;
        }else{ 
            printf("Error: %s. \n", $stmt->error);
            return false;
        }
    }

    //Delete Function
    public function delete(){

        //create query
        $query = "DELETE FROM " .$this->table. "
        WHERE id = :id";

        //prepare statment
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':id', $this->id);

        //execute query
        if($stmt->execute()){
            return true;
        }else{ 
            printf("Error: %s. \n", $stmt->error);
            return false;
        }

    }

}
?>    